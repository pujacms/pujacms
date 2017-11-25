<?php
namespace Puja\Bob\Module\Entity\Controller;

class IndexController extends \Puja\Bob\Controller\DataGrid\Entity\DataGridAbstract
{
    protected function getDataGridModel()
    {
        return \Puja\Bob\Module\Entity\Model\DataGrid\Configure\Index::getInstance($this);
    }

    protected function getModel()
    {
        return \Puja\Bob\Module\Entity\Model\DataGrid\DataSource::getInstance(
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

    protected function getIndexActionData()
    {
        $this->addJsonStore(array(
            'parentId' => $this->parentId,
        ));
        
        $data = parent::getIndexActionData();
        //$data['ConfigureModule'] = $this->getModel()->getConfigureModule();
        return $data;
    }

    protected function getLocalizeModel()
    {
        return null;
    }

}