<?php
namespace Puja\Bob\Module\System\Model\DataGrid;

class Language extends DataGridAbstract
{
    public function getTitle()
    {
        return 'Configure Cms Menu';
    }

    public function getActions()
    {
        return array('update', 'delete');
    }

    public function getEvents()
    {
        return array('onDrop' => 'onDrop', 'onLoadSuccess' => 'onLoadSuccess');
    }

    public function getFields()
    {
        return array(
            'locale' => array('title' => '#Locale', 'width' => '50', 'resizable' => true, 'sortable' => true),
            'name' => array('title' => 'Name', 'width' => '20%', 'resizable' => true, 'sortable' => true),
            'status' => array('title' => 'Status', 'align' => 'center', 'width' => '50', 'sortable' => true, 'formatter' => 'status'),
            'order_id' => array('title' => 'OrderId', 'align' => 'center', 'width' => '50', 'sortable' => true),
        );
    }

    public function getToolbars()
    {
        return array(
            array('name' => 'New', 'icon' => 'icon-add', 'fn' => 'update'),
        );
    }

    public function getPkField()
    {
        return \Puja\Bob\DbTable\Configure\Language::getInstance()->getPkField();
    }
}