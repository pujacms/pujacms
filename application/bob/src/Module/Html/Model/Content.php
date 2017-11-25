<?php
namespace Puja\Bob\Module\Html\Model;
use Puja\Bob\DbTable;
use Puja\Bob\Module\Entity\Model\EntityAbstract;

class Content extends EntityAbstract
{
    public function getTable()
    {
        return new DbTable\Entity\Html();
    }

    public function getRecordType()
    {
        return 'content';
    }


}