<?php
namespace Puja\Bob\Model\Html;
use Puja\Bob\DbTable;

class Html extends \Puja\Bob\Model\Entity\EntityAbstract
{
    protected static $recordType = 'content';

    protected function getTable()
    {
        return \Puja\Bob\DbTable\Html\Html::getInstance();
    }

    public function addRecordByPkId($pkId)
    {
        $this->table->insert(array($this->table->getPkField() => $pkId), true);
    }
}