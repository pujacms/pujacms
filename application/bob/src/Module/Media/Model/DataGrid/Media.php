<?php
namespace Puja\Bob\Module\Media\Model\DataGrid;


class Media extends \Puja\Bob\Model\DataGrid\ConfigureAbstract
{
    public function getToolbars()
    {
        return array(

        );
    }

    public function getTitle()
    {
        return 'Manage Medias';
    }

    public function getFields()
    {
        return array(
            'name' => array('title' => 'Name', 'formatter' => 'name', 'width' => '30%', 'resizable' => true, 'sortable' => true),

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
        return 'Puja.Configure.Grid';
    }

    public function getEvents()
    {
        return array();
    }

    public function getPkField()
    {
        return \Puja\Bob\DbTable\Media\Media::getInstance()->getPkField();
    }
}