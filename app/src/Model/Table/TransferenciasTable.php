<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transferencias Model
 *
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 *
 * @method \App\Model\Entity\Transferencia newEmptyEntity()
 * @method \App\Model\Entity\Transferencia newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Transferencia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transferencia get($primaryKey, $options = [])
 * @method \App\Model\Entity\Transferencia findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Transferencia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Transferencia[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transferencia|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transferencia saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transferencia[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Transferencia[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Transferencia[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Transferencia[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TransferenciasTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
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

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('pagador_id', 'Usuarios'), ['errorField' => 'pagador_id']);
        $rules->add($rules->existsIn('recebedor_id', 'Usuarios'), ['errorField' => 'recebedor_id']);

        return $rules;
    }
}
