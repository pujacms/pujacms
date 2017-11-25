<?php
namespace Puja\Bob\Module\Entity\Model\DataGrid\Configure;
use Puja\Bob\DbTable;
class Content extends \Puja\Bob\Model\DataGrid\Entity\ConfigureAbstract
{
    public function getPkField()
    {
        return DbTable\Content\Content::getInstance()->getPkField();
    }

    protected function getCategoryToolbar($cfgModule, $catLevel)
    {
        return null;
    }
}