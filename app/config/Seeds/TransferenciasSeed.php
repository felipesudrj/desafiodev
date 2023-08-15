<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Transferencias seed.
 */
class TransferenciasSeed extends AbstractSeed
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
                'pagador_id' => '1',
                'recebedor_id' => '2',
                'valor' => '1000.00',
                'created_at' => '2023-08-15 00:02:35',
                'notificado' => '1',
            ],
            [
                'id' => '2',
                'pagador_id' => '1',
                'recebedor_id' => '3',
                'valor' => '300.00',
                'created_at' => '2023-08-15 00:02:53',
                'notificado' => '1',
            ],
            [
                'id' => '5',
                'pagador_id' => '3',
                'recebedor_id' => '2',
                'valor' => '100.00',
                'created_at' => NULL,
                'notificado' => '0',
            ],
            [
                'id' => '6',
                'pagador_id' => '3',
                'recebedor_id' => '2',
                'valor' => '100.00',
                'created_at' => NULL,
                'notificado' => '0',
            ],
            [
                'id' => '7',
                'pagador_id' => '3',
                'recebedor_id' => '2',
                'valor' => '100.00',
                'created_at' => NULL,
                'notificado' => '0',
            ],
            [
                'id' => '8',
                'pagador_id' => '2',
                'recebedor_id' => '3',
                'valor' => '500.00',
                'created_at' => NULL,
                'notificado' => '0',
            ],
            [
                'id' => '9',
                'pagador_id' => '3',
                'recebedor_id' => '1',
                'valor' => '500.00',
                'created_at' => NULL,
                'notificado' => '0',
            ],
            [
                'id' => '11',
                'pagador_id' => '2',
                'recebedor_id' => '3',
                'valor' => '500.00',
                'created_at' => '2023-08-15 05:11:40',
                'notificado' => '0',
            ],
            [
                'id' => '12',
                'pagador_id' => '3',
                'recebedor_id' => '2',
                'valor' => '100.00',
                'created_at' => '2023-08-15 05:12:00',
                'notificado' => '0',
            ],
            [
                'id' => '13',
                'pagador_id' => '3',
                'recebedor_id' => '1',
                'valor' => '300.00',
                'created_at' => '2023-08-15 05:12:21',
                'notificado' => '0',
            ],
            [
                'id' => '14',
                'pagador_id' => '3',
                'recebedor_id' => '1',
                'valor' => '300.00',
                'created_at' => '2023-08-15 05:12:31',
                'notificado' => '0',
            ],
            [
                'id' => '15',
                'pagador_id' => '3',
                'recebedor_id' => '1',
                'valor' => '100.00',
                'created_at' => '2023-08-15 05:12:45',
                'notificado' => '0',
            ],
            [
                'id' => '16',
                'pagador_id' => '2',
                'recebedor_id' => '3',
                'valor' => '50.00',
                'created_at' => '2023-08-15 05:40:06',
                'notificado' => '0',
            ],
        ];

        $table = $this->table('transferencias');
        $table->insert($data)->save();
    }
}
