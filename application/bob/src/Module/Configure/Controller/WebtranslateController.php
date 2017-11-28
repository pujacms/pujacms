<?php
namespace Puja\Bob\Module\Configure\Controller;
use Puja\Bob\Model\Configure;
use Puja\Bob\Module\Configure\Model\DataGrid;


class WebtranslateController extends \Puja\Bob\Controller\DataGrid\DataGridAbstract
{

    protected function getModel()
    {
        return Configure\Webtranslate::getInstance();
    }

    protected function getDataGridModel()
    {
        return DataGrid\Webtranslate::getInstance($this);
    }
}