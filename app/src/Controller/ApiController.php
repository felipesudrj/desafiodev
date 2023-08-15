<?php

declare(strict_types=1);

/**
 * Controller resposável pelo controle de transações financeiras
 */

namespace App\Controller;

use App\Model\Table\UsuariosTable;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Client;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;
use Exception;

class ApiController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * função responsável pelo processo de transferência
     */
    public function transferencia()
    {

        try {

            $connection = ConnectionManager::get('default');
            $connection->begin();

            //VALIDAR FORMULÁRIO E USUÁRIO
            $this->validarFormulario();

            //VALIDAR SE TEM PERMISSÃO (PERFIL USUARIO)
            $this->validarPermissao();

            //VERIFICAR SALDO
            $this->verificarSaldo();

            //VERIFICAR SE TEM ESTA AUTORIZADO A TRANSFERIR (EXTERNO)         
            $this->verificarAutorizacaoExterna();

            //TRANSFERENCIA DE CARTEIRA
            $this->processarTransferencia();

            //NOTIFICAR O RECEBEDOR
            $this->notificacao();


            $info['msg'] = 'Transfêrencia realizada';

            $connection->commit();
        } catch (\Exception $e) {

            $connection->rollback();

            return $this->responseJsonError($e->getMessage());
        }

        return $this->responseJson($info);
    }

    private function notificacao()
    {
        try {

            /**
             * TODO - OBSERVAÇÃO DE MELHORIA
             * Em vez de notificar o usuário nesse momento, enviar uma mensagem para uma fila SQS
             * será mais rápido e se essa atividade não for algo fundamental, não irá travar a transação.
             */

            $valor = $this->request->getData('value') ?? null;
            $data['msg'] = 'Você recebeu uma transferência no valor de ' . $valor;
            $url = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';
            $client = new Client();
            $response = $client->post($url, $data);

            if (!$response->isOk()) {
                throw new Exception('Serviço indisponível, tente novamente mais tarde - Erro 58001');
            }


            //TODO - ATUALIZAR STATUS DE NOTIFICAÇÃO DA TRANSFERENCIA

        } catch (Exception $e) {

            throw $e;
        }
    }

    private function processarTransferencia()
    {


        $pagador_id = $this->request->getData('payer') ?? null;
        $recebedor_id = $this->request->getData('payee') ?? null;
        $valor_transferencia = $this->request->getData('value') ?? null;

        //REGISTRAR TRANSFERENCIA NA CARTEIRA DO RECEBEDOR
        $tabTransferencias = TableRegistry::getTableLocator()->get('Transferencias');
        $tabTransferencias->registrarTransferencia($pagador_id, $recebedor_id, $valor_transferencia);


        //ATUALIZAR SALDO DO PAGADOR
        $tabCarteira = TableRegistry::getTableLocator()->get('Carteiras');

        $saldo_pagador = $this->getSaldo($pagador_id);
        $saldo_atual = $saldo_pagador - $valor_transferencia;
        $tabCarteira->atualizarSaldo($pagador_id, $saldo_atual);


        //ATUALIZAR SALDO DO PAGADOR
        $saldo_recebedor = $this->getSaldo($recebedor_id);
        $saldo_atual = $saldo_recebedor + $valor_transferencia;
        $tabCarteira->atualizarSaldo($recebedor_id, $saldo_atual);
    }


    private function verificarAutorizacaoExterna()
    {

        $url = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

        $client = new Client();
        $response = $client->get($url);
        if (!$response->isOk()) {
            throw new Exception('Serviço indisponível, tente novamente mais tarde - Erro 57001');
        }

        $body = json_decode($response->getStringBody(), true);
        if ($body['message'] != 'Autorizado') {
            throw new Exception('Serviço indisponível, tente novamente mais tarde - Erro 57002');
        };

        return true;
    }

    private function getSaldo($usuario_id)
    {
        $tabCarteira = TableRegistry::getTableLocator()->get('Carteiras');
        $saldo = $tabCarteira->getSaldo($usuario_id);
        return $saldo;
    }

    private function verificarSaldo()
    {

        $pagador_id = $this->request->getData('payer') ?? null;
        $valor_transferencia = $this->request->getData('value') ?? null;
        $saldo = $this->getSaldo($pagador_id);

        if ($saldo < $valor_transferencia) {
            throw new Exception('Você não tem saldo suficiente para essa transferência');
        }

        return $saldo;
    }


    private function validarPermissao()
    {
        $check_pagador = $this->request->getData('payer') ?? null;
        $tabUsuarios = TableRegistry::getTableLocator()->get('Usuarios');

        $objUsuarioPagador = $tabUsuarios->getUsuario($check_pagador);

        if ($objUsuarioPagador->tipo->key == UsuariosTable::TIPO_LOJA) {
            throw new Exception('Lojistas não possuem permissão para realizar transferência, desculpe - Erro 5601');
        };
    }

    private function validarFormulario()
    {

        /**
         * TODO - SUGESTÃO DE MELHORIA
         * Criar uma biblioteca de mensagens de erros e validação
         */

        $check_pagador = $this->request->getData('payer') ?? null;
        $check_recebedor = $this->request->getData('payee') ?? null;
        $check_valor = $this->request->getData('value') ?? null;

        //VERIFICAR SE TODOS OS CAMPOS OBRIGATÓRIOS FORAM PREENCHIDOS
        if (empty($check_pagador) || empty($check_recebedor) || empty($check_valor)) {
            throw new Exception('Verifique se todos os campos obrigatórios do payload foram preenchidos - Erro 5501');
        }

        if (!is_int($check_pagador) || !is_int($check_recebedor)) {
            throw new Exception('Verifique o tipo enviado no campo payer ou payee - Erro 5501');
        }


        //VERIFICAR SE PAGADOR E RECEBEDOR EXISTEM NA BASE
        $tabUsuarios = TableRegistry::getTableLocator()->get('Usuarios');
        $usuarios_validos = $tabUsuarios->verificarUsuarioRecebedorEPagador($check_pagador, $check_recebedor);

        if (empty($usuarios_validos)) {
            throw new Exception('Verifique se você preencheu corretamente as identificações dos campos payer ou payee - Erro 5502');
        }


        //NÃO PERMITIR FAZER TRANSFERENCIA PARA A MESMA CONTA
        if ($check_pagador === $check_recebedor) {
            throw new Exception('Não é possível fazer transferência para a mesma conta - Erro 5503');
        }


        $check_valor = floatval($check_valor);

        //VERIFICAR SE VALOR DE TRANSFERÊNCIA É POSITIVO
        if ($check_valor <= 0) {
            throw new Exception('Informe um valor válido de transferencia - Erro 5504');
        }
    }
}
