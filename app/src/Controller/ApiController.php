<?php

declare(strict_types=1);

/**
 * Controller resposável pelo controle de transações financeiras
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
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
            //VALIDAR SE TEM SALDO
            //VERIFICAR SE ESTÁ AUTORIZADO A REALIZAR A TRANSFERENCIA
            //NOTIFICAR O RECEBEDOR
            //ATUALIZAR SALDO DO RECEBEDOR E DO PAGADOR


            $info['msg'] = 'Transfêrencia realizada';
        } catch (\Exception $e) {

            return $this->responseJsonError($e->getMessage());
        }

        return $this->responseJson($info);
    }


    private function validarFormulario()
    {

        $check_pagador = $this->request->getData('payer') ?? null;
        $check_recebedor = $this->request->getData('payee') ?? null;
        $check_valor = $this->request->getData('value') ?? null;

        //VERIFICAR SE TODOS OS CAMPOS OBRIGATÓRIOS FORAM PREENCHIDOS
        if (empty($check_pagador) || empty($check_recebedor) || empty($check_valor)) {

            die('errou');
            throw new Exception('Verifique se todos os campos obrigatórios do payload foram preenchidos');
        }


        //VERIFICAR SE PAGADO E RECEBEDOR EXISTEM NA BASE
        
        
        //VERIFICAR SE VALOR DE TRANSFERÊNCIA É POSITIVO
    }
}
