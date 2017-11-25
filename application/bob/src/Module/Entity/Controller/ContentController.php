<?php
namespace Puja\Bob\Module\Entity\Controller;

class ContentController extends \Puja\Bob\Controller\DataGrid\Entity\DataGridMultiLnAbstract
{
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
        return \Puja\Bob\Model\Content\ContentLocalize::getInstance(
            $this->idConfigureModule,
            $this->getCurrentCfgModule(),
            $this->configureLanguageId
        );
    }
}