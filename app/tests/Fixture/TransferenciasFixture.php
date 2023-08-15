<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TransferenciasFixture
 */
class TransferenciasFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'pagador_id' => 1,
                'recebedor_id' => 1,
                'valor' => 1,
                'created_at' => '2023-08-15 03:06:25',
                'notificado' => 1,
            ],
        ];
        parent::init();
    }
}
