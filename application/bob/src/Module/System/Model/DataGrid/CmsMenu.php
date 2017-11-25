<?php
namespace Puja\Bob\Module\System\Model\DataGrid;

class CmsMenu extends DataGridAbstract
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

    public function getToolbars()
    {
        return array(
            array('name' => 'New Menu', 'icon' => 'icon-add', 'fn' => 'create'),
            array('name' => 'Manage Menu Items', 'icon' => 'icon-edit', 'fn' => 'manageMenu')
        );
    }

    public function getPkField()
    {
        return \Puja\Bob\DbTable\Configure\CmsMenu::getInstance()->getPkField();
    }
}