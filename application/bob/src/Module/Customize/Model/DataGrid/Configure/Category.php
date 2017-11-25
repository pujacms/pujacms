<?php
namespace Puja\Bob\Module\Customize\Model\DataGrid\Configure;

class Category extends \Puja\Bob\Model\DataGrid\Entity\ConfigureAbstract
{
    public function getPkField()
    {
        $cfgModule = $this->controller->getCurrentCfgModule();
        if (!empty($cfgModule['core_data']['category']['tbl']['pk_field'])) {
            return $cfgModule['core_data']['category']['tbl']['pk_field'];
        }
    }

    protected function getContentToolbar($cfgModule, $catLevel)
    {
        return null;
    }
}