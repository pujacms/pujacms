<?php
namespace Puja\Bob\Module\System\Model\DataGrid;

class ConfigureGroup extends DataGridAbstract
{
    public function getTitle()
    {
        return 'Configure Group';
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
            array('name' => 'New', 'icon' => 'icon-add', 'fn' => 'update'),
            array('name' => 'Back to Manage Configurations', 'icon' => 'tree-file', 'fn' => 'manageConfigure'),
        );
    }

    public function getPkField()
    {
        return \Puja\Bob\DbTable\Configure\Group::getInstance()->getPkField();
    }
}