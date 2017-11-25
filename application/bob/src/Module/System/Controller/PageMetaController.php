<?php
namespace Puja\Bob\Module\System\Controller;
use Puja\Bob\Module\System\Form\ModuleCreate;
use Puja\Bob\Module\System\Form\ModuleUpdate;
use Puja\Bob\Service\ModuleType;
use Puja\Configure\Configure;
use Puja\Bob\Module\System\Model\DataGrid;

class PageMetaController extends \Puja\Bob\Controller\DataGrid\DataGridAbstract
{
    /**
     * @return \Puja\Bob\Model\Configure\Module
     */
    protected function getModel()
    {
        return \Puja\Bob\Model\Configure\PageMeta::getInstance();
    }

    protected function getDataGridModel()
    {
        return DataGrid\PageMeta::getInstance($this);
    }



    

}