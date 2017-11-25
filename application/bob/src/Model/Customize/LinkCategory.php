<?php
namespace Puja\Bob\Model\Customize;

class LinkCategory extends \Puja\Bob\Model\Entity\LinkCategoryAbstract
{
    protected static $modelName = 'CustomizeLink';
    protected function getTable()
    {
        if (empty($this->cfgModule['core_data']['category']['tbl'])) {
            return null;
        }

        $table = \Puja\Bob\DbTable\Customize\Link::getInstance(
            $this->cfgModule['core_data']['category']['tbl']['name'] . '_link'
        );
        $table->setPkField('fk_' . $this->cfgModule['core_data']['content']['tbl']);
        $table->setParentField('fk_' . $this->cfgModule['core_data']['category']['tbl']);

        return $table;
    }
}