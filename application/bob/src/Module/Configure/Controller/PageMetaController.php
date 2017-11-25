<?php
namespace Puja\Bob\Module\Configure\Controller;

class PageMetaController extends \Puja\Bob\Controller\DataGrid\DataGridAbstract
{

    protected function getModel()
    {
        return \Puja\Bob\Model\Configure\PageMeta::getInstance();
    }

    protected function getDataGridModel()
    {
        return \Puja\Bob\Module\Configure\Model\DataGrid\PageMeta::getInstance($this);
    }
    
}