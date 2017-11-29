<?php
namespace Puja\Bob\Module\Configure\Model\DataGrid;

class Webtranslate extends \Puja\Bob\Model\DataGrid\ConfigureAbstract
{
    public function getToolbars()
    {
        return array(
            array('name' => 'New', 'icon' => 'icon-add', 'fn' => 'create'),
            array('name' => 'Import to Alice', 'icon' => 'icon-filter', 'fn' => 'importAlice'),
        );
    }

    public function getTitle()
    {
        return 'Webtranslate';
    }

    public function getFields()
    {
        return array(
            'translate_key' => array('title' => 'Key', 'formatter' => 'name', 'width' => '30%', 'resizable' => true, 'sortable' => true),
        );
    }

    public function getActions()
    {
        return array('update', 'delete');
    }

    public function getUrl()
    {
        return './?module=' . $this->controller->getModuleId() .
        '&ctrl=' . $this->controller->getControllerId() .
        '&act=list&parentid=' . $this->controller->getParam('parentid', 0);
    }

    public function getJsHandler()
    {
        return 'Puja.Configure.Grid';
    }

    public function getEvents()
    {
        return array();
    }

    public function getPkField()
    {
        return \Puja\Bob\DbTable\Configure\Webtranslate::getInstance()->getPkField();
    }

    public function getEnableFilter()
    {
        return true;
    }
}