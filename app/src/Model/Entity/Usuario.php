<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Usuario Entity
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $doc
 * @property string|null $email
 * @property string|null $senha
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime|null $updated_at
 * @property int|null $tipo_id
 *
 * @property \App\Model\Entity\Tipo $tipo
 * @property \App\Model\Entity\Carteira[] $carteiras
 */
class Usuario extends Entity
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
        'nome' => true,
        'doc' => true,
        'email' => true,
        'senha' => true,
        'created_at' => true,
        'updated_at' => true,
        'tipo_id' => true,
        'tipo' => true,
        'carteiras' => true,
    ];
}
