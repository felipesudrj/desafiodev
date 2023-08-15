<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transferencia Entity
 *
 * @property int $id
 * @property int|null $pagador_id
 * @property int|null $recebedor_id
 * @property float|null $valor
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property int|null $notificado
 *
 * @property \App\Model\Entity\Usuario $usuario
 */
class Transferencia extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'pagador_id' => true,
        'recebedor_id' => true,
        'valor' => true,
        'created_at' => true,
        'notificado' => true,
        'usuario' => true,
    ];
}
