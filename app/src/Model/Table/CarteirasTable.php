<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class CarteirasTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('carteiras');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
        ]);
    }


    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('usuario_id')
            ->allowEmptyString('usuario_id');

        $validator
            ->integer('saldo')
            ->allowEmptyString('saldo');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        return $validator;
    }


    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('usuario_id', 'Usuarios'), ['errorField' => 'usuario_id']);

        return $rules;
    }

    public function getSaldo($usuario)
    {

        $objEncontrado = $this->find()
            ->where(['Carteiras.usuario_id' => $usuario])
            ->first();

        if (empty($objEncontrado)) {
            return 0;
        }

        return $objEncontrado->get('saldo');
    }
}
