<?php
namespace Puja\Bob\DbTable\Entity;

abstract class EntityLocalizeAbstract extends EntityAbstract
{
    public function getByPkId($pkId)
    {
        return $this->findByCriteria(array(
            $this->pkField => $pkId,
        ));
    }
}