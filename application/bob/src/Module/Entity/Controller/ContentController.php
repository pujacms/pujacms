<?php
namespace Puja\Bob\Module\Entity\Controller;

class ContentController extends \Puja\Bob\Controller\DataGrid\Entity\ContentAbstract
{
    /**
     * @var \Puja\Bob\Model\Content\Content
     */
    protected $model;
    protected function getDataGridModel()
    {
        return \Puja\Bob\Module\Entity\Model\DataGrid\Configure\Content::getInstance($this);
    }

    protected function getModel()
    {
        return \Puja\Bob\Model\Content\Content::getInstance(
            $this->idConfigureModule,
            $this->getCurrentCfgModule(),
            $this->configureLanguageId
        );
    }

    /**
     * @return \Puja\Bob\Model\Category\Category
     */
    protected function getCategoryModel()
    {
        return \Puja\Bob\Model\Category\Category::getInstance(
            $this->idConfigureModule,
            $this->getCurrentCfgModule(),
            $this->configureLanguageId
        );
    }
}