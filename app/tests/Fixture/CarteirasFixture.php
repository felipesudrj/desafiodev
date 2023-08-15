<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CarteirasFixture
 */
class CarteirasFixture extends TestFixture
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
                'usuario_id' => 1,
                'saldo' => 1,
                'updated_at' => '2023-08-15 03:06:07',
            ],
        ];
        parent::init();
    }
}
