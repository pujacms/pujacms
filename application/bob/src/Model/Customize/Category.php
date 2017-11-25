<?php
namespace Puja\Bob\Model\Customize;

class Category extends \Puja\Bob\Model\Entity\CategoryAbstract
{
    protected static $recordType = 'category';
    protected static $modelName = 'CustomizeCategory';

    protected function getTable()
    {
        if (empty($this->cfgModule['core_data']['category']['tbl'])) {
            return null;
        }

        $table = \Puja\Bob\DbTable\Customize\Category::getInstance($this->cfgModule['core_data']['category']['tbl']['name']);
        $table->setPkField($this->cfgModule['core_data']['category']['tbl']['pk_field']);
        $table->setParentField($this->cfgModule['core_data']['category']['tbl']['parent_field']);
        return $table;
    }
    
    
}