<?php
namespace Puja\Bob\Model\Customize;

class Content extends \Puja\Bob\Model\Entity\ContentAbstract
{
    protected static $modelName = 'CustomizeContent';
    protected static $recordType = 'content';

    protected function getTable()
    {
        if (empty($this->cfgModule['core_data']['content']['tbl'])) {
            return null;
        }

        $table = \Puja\Bob\DbTable\Customize\Content::getInstance($this->cfgModule['core_data']['content']['tbl']['name']);
        $table->setPkField($this->cfgModule['core_data']['content']['tbl']['pk_field']);
        $table->setParentField($this->cfgModule['core_data']['content']['tbl']['parent_field']);
        return $table;
    }

    protected function getLinkModel()
    {
        return LinkCategory::getInstance();
    }
}