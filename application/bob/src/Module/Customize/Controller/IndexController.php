<?php
namespace Puja\Bob\Module\Customize\Controller;
use \Puja\Bob\Module\Customize\Model\DataGrid;

class IndexController extends \Puja\Bob\Controller\DataGrid\Entity\DataGridAbstract
{
    protected function getDataGridModel()
    {
        return DataGrid\Configure\Index::getInstance($this);
    }

    protected function getModel()
    {
        return DataGrid\DataSource::getInstance(
            $this->idConfigureModule,
            $this->getCurrentCfgModule()
        );
    }

    protected function getCategoryModel()
    {
        return \Puja\Bob\Model\Customize\Category::getInstance(
            $this->idConfigureModule,
            $this->getCurrentCfgModule()
        );
    }
}