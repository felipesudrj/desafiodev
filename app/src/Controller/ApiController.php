<?php

declare(strict_types=1);

/**
 * Controller resposável pelo controle de transações financeiras
 */

namespace App\Controller;

use App\Model\Table\UsuariosTable;
use Cake\Core\Configure;
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


            //VALIDAR FORMULÁRIO E USUÁRIO
            $this->validarFormulario();
            //VALIDAR SE TEM PERMISSÃO (PERFIL USUARIO)
            $this->validarPermissao();
            //VERIFICAR SALDO
            $saldo = $this->verificarSaldo();
            //VERIFICAR SE TEM ESTA AUTORIZADO A TRANSFERIR (EXTERNO)            
            //NOTIFICAR O RECEBEDOR
            //ATUALIZAR SALDO DO RECEBEDOR E DO PAGADOR


            $info['msg'] = 'Transfêrencia realizada';
        } catch (\Exception $e) {

            return $this->responseJsonError($e->getMessage());
        }

        return $this->responseJson($info);
    }

    private function verificarSaldo()
    {

        $pagador_id = $this->request->getData('payer') ?? null;
        $valor_transferencia = $this->request->getData('value') ?? null;


        $tabCarteira = TableRegistry::getTableLocator()->get('Carteiras');
        $saldo = $tabCarteira->getSaldo($pagador_id);

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

        $check_pagador = $this->request->getData('payer') ?? null;
        $check_recebedor = $this->request->getData('payee') ?? null;
        $check_valor = $this->request->getData('value') ?? null;

        //VERIFICAR SE TODOS OS CAMPOS OBRIGATÓRIOS FORAM PREENCHIDOS
        if (empty($check_pagador) || empty($check_recebedor) || empty($check_valor)) {

            throw new Exception('Verifique se todos os campos obrigatórios do payload foram preenchidos - Erro 5501');
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
