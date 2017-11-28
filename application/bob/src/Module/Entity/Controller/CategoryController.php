<?php
namespace Puja\Bob\Module\Entity\Controller;

class CategoryController extends \Puja\Bob\Controller\DataGrid\Entity\DataGridMultiLnAbstract
{
    /**
     * @var \Puja\Bob\Model\Category\Category
     */
    protected $model;
    protected function getDataGridModel()
    {
        return \Puja\Bob\Module\Entity\Model\DataGrid\Configure\Category::getInstance($this);
    }

    protected function getModel()
    {
        return \Puja\Bob\Model\Category\Category::getInstance(
            $this->idConfigureModule,
            $this->getCurrentCfgModule(),
            $this->configureLanguageId
        );
    }

    protected function getCategoryModel()
    {
        return \Puja\Bob\Model\Category\Category::getInstance(
            $this->idConfigureModule,
            $this->getCurrentCfgModule(),
            $this->configureLanguageId
        );
    }

    protected function getLocalizeModel()
    {
        return \Puja\Bob\Model\Category\CategoryLocalize::getInstance(
            $this->idConfigureModule,
            $this->getCurrentCfgModule(),
            $this->configureLanguageId
        );
    }

}