<?php
namespace Puja\Bob\Module\Customize\Model\DataGrid\Configure;

class Content extends \Puja\Bob\Model\DataGrid\Entity\ConfigureAbstract
{
    public function getPkField()
    {
        $cfgModule = $this->controller->getCurrentCfgModule();
        if (!empty($cfgModule['core_data']['content']['tbl']['pk_field'])) {
            return $cfgModule['core_data']['content']['tbl']['pk_field'];
        }
    }

    protected function getCategoryToolbar($cfgModule, $catLevel)
    {
        return null;
    }
}