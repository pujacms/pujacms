<?php
namespace Puja\Bob\Module\Customize\Model\DataGrid;
use Puja\Bob\DbTable;


class DataSource extends \Puja\Bob\Model\DataGrid\Entity\DataSourceAbstract
{
    protected function getContentTable()
    {
        if (empty($this->cfgModule['core_data']['content']['tbl'])) {
            return null;
        }

        $table = \Puja\Bob\DbTable\Customize\Content::getInstance($this->cfgModule['core_data']['content']['tbl']['name']);
        $table->setPkField($this->cfgModule['core_data']['content']['tbl']['pk_field']);
        $table->setParentField($this->cfgModule['core_data']['content']['tbl']['parent_field']);


        return $table;
    }

    protected function getCategoryTable()
    {
        if (empty($this->cfgModule['core_data']['category']['tbl'])) {
            return null;
        }

        $table = \Puja\Bob\DbTable\Customize\Content::getInstance($this->cfgModule['core_data']['category']['tbl']['name']);
        $table->setPkField($this->cfgModule['core_data']['category']['tbl']['pk_field']);
        $table->setParentField($this->cfgModule['core_data']['category']['tbl']['parent_field']);

        return $table;
    }
}