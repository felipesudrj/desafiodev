<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Exception;

class TransferenciasTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('transferencias');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'pagador_id',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'recebedor_id',
        ]);
    }


    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('pagador_id')
            ->allowEmptyString('pagador_id');

        $validator
            ->integer('recebedor_id')
            ->allowEmptyString('recebedor_id');

        $validator
            ->numeric('valor')
            ->allowEmptyString('valor');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->integer('notificado')
            ->allowEmptyString('notificado');

        return $validator;
    }


    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('pagador_id', 'Usuarios'), ['errorField' => 'pagador_id', 'message' => 'Verifique o código do pagador']);
        $rules->add($rules->existsIn('recebedor_id', 'Usuarios'), ['errorField' => 'recebedor_id', 'message' => 'Verifique o código do recebedor']);

        return $rules;
    }

    public function registrarTransferencia($pagador_id, $recebedor_id, $valor_transferencia)
    {
        $arrData['pagador_id'] = $pagador_id;
        $arrData['recebedor_id'] = $recebedor_id;
        $arrData['valor'] = $valor_transferencia;
        $arrData['notificado'] = 0;
        $arrData['created_at'] = date('Y-m-d H:i:s');

        $objEntity = $this->newEmptyEntity();
        $objEntity = $this->patchEntity($objEntity, $arrData);


        if ($objEntity->hasErrors()) {
            throw new Exception('Erro ao registrar a transferência.');
        }

        $this->save($objEntity);

        return $objEntity->id;
    }
}
