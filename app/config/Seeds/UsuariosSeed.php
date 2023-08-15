<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Usuarios seed.
 */
class UsuariosSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '1',
                'nome' => 'Felipe',
                'doc' => '11413163742',
                'email' => 'felipe.devel@gmail.com',
                'senha' => NULL,
                'created_at' => '2023-08-14 23:59:24',
                'updated_at' => '2023-08-14 23:59:24',
                'tipo_id' => '1',
            ],
            [
                'id' => '2',
                'nome' => 'Fernanda',
                'doc' => '34055257805',
                'email' => 'fernandakel@hotmail.com',
                'senha' => NULL,
                'created_at' => '2023-08-14 23:59:47',
                'updated_at' => '2023-08-14 23:59:48',
                'tipo_id' => '2',
            ],
            [
                'id' => '3',
                'nome' => 'Gabriel Marassi',
                'doc' => '65455887554',
                'email' => 'gabriel@gmail.com',
                'senha' => NULL,
                'created_at' => '2023-08-15 00:00:15',
                'updated_at' => '2023-08-15 00:00:16',
                'tipo_id' => '2',
            ],
        ];

        $table = $this->table('usuarios');
        $table->insert($data)->save();
    }
}
