<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Tipos seed.
 */
class TiposSeed extends AbstractSeed
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
                'descricao' => 'Lojista',
                'key' => 'LOJA',
            ],
            [
                'id' => '2',
                'descricao' => 'Usuários',
                'key' => 'USUARIOS',
            ],
        ];

        $table = $this->table('tipos');
        $table->insert($data)->save();
    }
}
