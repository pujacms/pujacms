<?php
namespace Puja\Bob\DbTable\Entity;

abstract class LinkAbstract extends \Puja\Bob\DbTable\TableAbstract\TableAbstract
{
    protected $parentField;

    public function getParentField()
    {
        return $this->parentField;
    }

    public function setPkField($pkField)
    {
        $this->pkField = $pkField;
    }

    public function setParentField($parentField)
    {
        $this->parentField = $parentField;
    }
}