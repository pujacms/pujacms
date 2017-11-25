<?php
namespace Puja\Bob\DbTable\Customize;

abstract class CustomizeAbstract extends \Puja\Bob\DbTable\Entity\EntityAbstract
{
    public function setPkField($pkField)
    {
        $this->pkField = $pkField;
    }

    public function setParentField($parentField)
    {
        $this->parentField = $parentField;
    }
}