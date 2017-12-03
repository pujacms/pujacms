<?php
namespace Puja\Bob\Module\Customize\Controller;

class CategoryController extends \Puja\Bob\Controller\DataGrid\Entity\CategoryAbstract
{
    protected $configureLanguageId = null;
    protected function getDataGridModel()
    {
        return \Puja\Bob\Module\Customize\Model\DataGrid\Configure\Category::getInstance($this);
    }

    protected function getModel()
    {
        return \Puja\Bob\Model\Customize\Category::getInstance(
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