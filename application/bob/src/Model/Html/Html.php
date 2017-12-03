<?php
namespace Puja\Bob\Model\Html;
use Puja\Bob\DbTable;

class Html extends \Puja\Bob\Model\Entity\EntityAbstract
{
    protected static $recordType = 'content';

    protected function getTable()
    {
        $table = \Puja\Bob\DbTable\Html\Html::getInstance();
        $table->setIdConfigureLanguageDefault($this->idConfigureLanguage);
        $table->setTableLocalize($this->getTableLocalize());
        return $table;
        
    }

    protected function getTableLocalize()
    {
        return \Puja\Bob\DbTable\Html\HtmlLn::getInstance();
    }

    public function addRecordByPkId($pkId)
    {
        $this->table->insert(array($this->table->getPkField() => $pkId), true);
    }
}