<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class UsuariosTable extends Table
{
    const TIPO_LOJA = 'LOJA';
    const TIPO_USUARIO = 'USUARIO';

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('usuarios');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tipos', [
            'foreignKey' => 'tipo_id',
        ]);
        $this->hasMany('Carteiras', [
            'foreignKey' => 'usuario_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('nome')
            ->maxLength('nome', 255)
            ->allowEmptyString('nome');

        $validator
            ->scalar('doc')
            ->maxLength('doc', 255)
            ->allowEmptyString('doc');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('senha')
            ->maxLength('senha', 255)
            ->allowEmptyString('senha');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        $validator
            ->integer('tipo_id')
            ->allowEmptyString('tipo_id');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('tipo_id', 'Tipos'), ['errorField' => 'tipo_id']);

        return $rules;
    }

    public function getUsuario($usuario)
    {
        return $this->find()
            ->contain(['Tipos'])
            ->where(
                ['Usuarios.id' => $usuario]
            )
            ->first();
    }

    public function verificarUsuarioRecebedorEPagador($pagador, $recebedor)
    {

        if (empty($this->getUsuario($pagador))) {
            return false;
        };

        if (empty($this->getUsuario($recebedor))) {
            return false;
        };

        return true;
    }
}
