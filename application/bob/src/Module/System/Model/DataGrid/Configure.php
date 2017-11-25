<?php
namespace Puja\Bob\Module\System\Model\DataGrid;

class Configure extends DataGridAbstract
{
    public function getToolbars()
    {
        $toolbars =  array(
            array('name' => 'New', 'icon' => 'icon-add', 'fn' => 'update'),
            array('name' => 'Manage Configure Group', 'icon' => 'tree-folder', 'fn' => 'manageGroup')
        );

        if ($this->controller->getParam('parentid')) {
            $toolbars[] = array('name' => 'Clear search', 'icon' => 'icon-cancel', 'fn' => 'clearGroup');
        }

        return $toolbars;
    }

    public function getFields()
    {
        return array(
            'name' => array('title' => 'Name', 'formatter' => 'name', 'width' => '20%', 'resizable' => true, 'sortable' => true),
            'code' => array('title' => '#Code', 'width' => '150', 'resizable' => true, 'sortable' => true),
            'value' => array('title' => 'Value', 'width' => '30%', 'resizable' => true, 'sortable' => true),
            'configure_group_id' => array('title' => 'Group Name', 'width' => '200', 'sortable' => true, 'formatter' => 'group'),
        );
    }

    public function getTitle()
    {
        return 'Manage Configurations';
    }

    public function getPkField()
    {
        return \Puja\Bob\DbTable\Configure\Configure::getInstance()->getPkField();
    }
}