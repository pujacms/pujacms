<?php
namespace Puja\Bob\Model\Entity;
use Puja\Bob\DbTable;
abstract class LinkCategoryAbstract extends \Puja\Bob\Model\AbstractLayer\BaseAbstract
{
    /**
     * @var DbTable\Entity\LinkAbstract
     */
    protected $table;

    public static function getInstance()
    {
        if (empty(static::$modelName)) {
            return new static();
        }

        if (empty(static::$instances[static::$modelName])) {
            static::$instances[static::$modelName] = new static();
        }

        return static::$instances[static::$modelName];
    }

    public function addLinkCategory($pkId, $parentId)
    {
        echo $pkId . ' : ' . $parentId;exit;
    }

}