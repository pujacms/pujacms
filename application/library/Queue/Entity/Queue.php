<?php
namespace Puja\Library\Queue\Entity;
use Puja\Entity\Entity;

/**
 * Class Queue
 * @package Puja\Library\Queue\Entity
 * @method getId_queue()
 * @method setId_queue($idQueue)
 * @method getCode()
 * @method setCode()
 * @method getCreated_at()
 * @method setCreated_at()
 * @method getUpdated_at()
 * @method seUpdated_at()
 */
class Queue extends Entity
{
    protected $attributes = array(
        'id_queue' => null,
        'code' => null,
        'status' => null,
        'created_at' => null,
        'updated_at' => null,
    );
}