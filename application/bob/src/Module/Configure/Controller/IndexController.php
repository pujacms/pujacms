<?php
namespace Puja\Bob\Module\Configure\Controller;
use Puja\Bob\Model\Configure;
use Puja\Bob\Module\Configure\Model\DataGrid;


class IndexController extends \Puja\Bob\Controller\DataGrid\DataGridAbstract
{

    protected function getModel()
    {
        return Configure\Configure::getInstance();
    }

    protected function getDataGridModel()
    {
        return DataGrid\Configure::getInstance($this);
    }
}