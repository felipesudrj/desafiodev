<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Carteiras seed.
 */
class CarteirasSeed extends AbstractSeed
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
                'usuario_id' => '1',
                'saldo' => '1700',
                'updated_at' => '2023-08-15 05:12:45',
            ],
            [
                'id' => '2',
                'usuario_id' => '2',
                'saldo' => '150',
                'updated_at' => '2023-08-15 05:40:06',
            ],
            [
                'id' => '3',
                'usuario_id' => '3',
                'saldo' => '50',
                'updated_at' => '2023-08-15 05:40:06',
            ],
        ];

        $table = $this->table('carteiras');
        $table->insert($data)->save();
    }
}
