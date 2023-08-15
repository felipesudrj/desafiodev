<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class InicioDataBase extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up(): void
    {
        $this->table('carteiras')
            ->addColumn('usuario_id', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('saldo', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('updated_at', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'usuario_id',
                ],
                [
                    'name' => 'FK_carteiras_usuarios',
                ]
            )
            ->create();

        $this->table('tipos')
            ->addColumn('descricao', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('key', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->create();

        $this->table('transferencias')
            ->addColumn('pagador_id', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('recebedor_id', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('valor', 'float', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('created_at', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('notificado', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'recebedor_id',
                ],
                [
                    'name' => 'FK2_recebedor',
                ]
            )
            ->addIndex(
                [
                    'pagador_id',
                ],
                [
                    'name' => 'FK1_pagador',
                ]
            )
            ->create();

        $this->table('usuarios')
            ->addColumn('nome', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('doc', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('senha', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created_at', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('updated_at', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('tipo_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'tipo_id',
                ],
                [
                    'name' => 'FK1_tipo_usuario',
                ]
            )
            ->create();

        $this->table('carteiras')
            ->addForeignKey(
                'usuario_id',
                'usuarios',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK_carteiras_usuarios'
                ]
            )
            ->update();

        $this->table('transferencias')
            ->addForeignKey(
                'recebedor_id',
                'usuarios',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK2_recebedor'
                ]
            )
            ->addForeignKey(
                'pagador_id',
                'usuarios',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK1_pagador'
                ]
            )
            ->update();

        $this->table('usuarios')
            ->addForeignKey(
                'tipo_id',
                'tipos',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                    'constraint' => 'FK1_tipo_usuario'
                ]
            )
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down(): void
    {
        $this->table('carteiras')
            ->dropForeignKey(
                'usuario_id'
            )->save();

        $this->table('transferencias')
            ->dropForeignKey(
                'recebedor_id'
            )
            ->dropForeignKey(
                'pagador_id'
            )->save();

        $this->table('usuarios')
            ->dropForeignKey(
                'tipo_id'
            )->save();

        $this->table('carteiras')->drop()->save();
        $this->table('tipos')->drop()->save();
        $this->table('transferencias')->drop()->save();
        $this->table('usuarios')->drop()->save();
    }
}
