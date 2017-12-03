<?php
namespace Puja\Bob\Module\Customize\Controller;

class ContentController extends \Puja\Bob\Controller\DataGrid\Entity\ContentAbstract
{
    protected $configureLanguageId = null;
    protected function getDataGridModel()
    {
        return \Puja\Bob\Module\Customize\Model\DataGrid\Configure\Content::getInstance($this);
    }

    protected function getModel()
    {
        return \Puja\Bob\Model\Customize\Content::getInstance(
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