<?php
namespace Puja\Bob\Model\Configure;
use Puja\Bob\DbTable;
class Webtranslate extends \Puja\Bob\Model\AbstractLayer\ModelAbstract
{
    protected function getTable()
    {
        return DbTable\Configure\Webtranslate::getInstance();
    }


    protected function getCondByQuery($query = null)
    {
        if (empty($query)) {
            return '1';
        }

        return $this->table->getShortTableName() . '.translate_key LIKE "%' . $query . '%"';
    }
}