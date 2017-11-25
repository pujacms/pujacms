<?php
namespace Puja\Bob\Module\System\Model\DataGrid;

class CmsTheme extends DataGridAbstract
{
    public function getTitle()
    {
        return 'Configure Cms Theme';
    }

    public function getFields()
    {
        return array(
            'name' => array('title' => 'Name', 'formatter' => 'name', 'width' => '30%', 'resizable' => true, 'sortable' => true),
            'status' => array('title' => 'Status', 'formatter' => 'status', 'width' => '50', 'resizable' => true, 'sortable' => true),
            //'order_id' => array('title' => 'Order Id', 'align' => 'center', 'width' => '120', 'sortable' => true),
        );
    }

    public function getActions()
    {
        return array('update', 'delete');
    }

    public function getEvents()
    {
        return array('onDrop' => 'onDrop', 'onLoadSuccess' => 'onLoadSuccess');
    }

    public function getToolbars()
    {
        return array(
            array('name' => 'New Theme', 'icon' => 'icon-add', 'fn' => 'update'),
        );
    }

    public function getPkField()
    {
        return \Puja\Bob\DbTable\Configure\CmsTheme::getInstance()->getPkField();
    }
}