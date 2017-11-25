<?php
namespace Puja\Bob\Module\Entity\Model\DataGrid\Configure;
use Puja\Bob\DbTable;
class Category extends \Puja\Bob\Model\DataGrid\Entity\ConfigureAbstract
{
    public function getPkField()
    {
        return DbTable\Category\Category::getInstance()->getPkField();
    }

    protected function getContentToolbar($cfgModule, $catLevel)
    {
        return null;
    }
}