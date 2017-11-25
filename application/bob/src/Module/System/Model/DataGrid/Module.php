<?php
namespace Puja\Bob\Module\System\Model\DataGrid;

class Module extends DataGridAbstract
{
    public function getTitle()
    {
        return 'Configure Modules';
    }

    public function getFields()
    {
        return array(
            'name' => array('title' => 'Name', 'formatter' => 'name', 'width' => '50%', 'resizable' => true, 'sortable' => true),
            'module_type_id' => array('title' => 'Module Type', 'align' => 'center', 'width' => '120', 'sortable' => true, 'formatter' => 'moduleTypeId'),
        );
    }
    
    public function getPkField()
    {
        return \Puja\Bob\DbTable\Configure\Module::getInstance()->getPkField();
    }
}