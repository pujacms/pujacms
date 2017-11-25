<?php
namespace Puja\Bob\Module\System\Model\DataGrid;

abstract class DataGridAbstract extends \Puja\Bob\Model\DataGrid\ConfigureAbstract
{
    public function getToolbars()
    {
        return array(
            array('name' => 'New', 'icon' => 'icon-add', 'fn' => 'create')
        );
    }

    public function getFields()
    {
        return array(
            'name' => array('title' => 'Name', 'formatter' => 'name', 'width' => '30%', 'resizable' => true, 'sortable' => true),
            'status' => array('title' => 'Status', 'formatter' => 'status', 'width' => '50', 'align' => 'center', 'resizable' => true, 'sortable' => true),
            'order_id' => array('title' => 'Order Id', 'align' => 'center', 'width' => '120', 'sortable' => true),
        );
    }

    public function getActions()
    {
        return array('update');
    }

    public function getUrl()
    {
        return './?module=' . $this->controller->getModuleId() .
        '&ctrl=' . $this->controller->getControllerId() .
        '&act=list&parentid=' . $this->controller->getParam('parentid', 0);
    }

    public function getJsHandler()
    {
        return 'Puja.System.Grid';
    }

    public function getEvents()
    {
        return array();
    }
}