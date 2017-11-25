<?php
namespace Puja\Bob\Module\System\Model\DataGrid;

class PageMeta extends DataGridAbstract
{
    public function getTitle()
    {
        return 'Configure Page Meta';
    }

    public function getFields()
    {
        return array(
            'name' => array('title' => 'Name', 'formatter' => 'name', 'width' => '50%', 'resizable' => true, 'sortable' => true),
            'status' => array('title' => 'Status', 'formatter' => 'status', 'width' => '50', 'resizable' => true, 'align' => 'center', 'sortable' => true),
            'configure_module' => array('title' => 'Source', 'formatter' => 'configure_module', 'width' => '10%', 'resizable' => true, 'sortable' => true),
            //'module_type_id' => array('title' => 'Module Type', 'align' => 'center', 'width' => '120', 'sortable' => true, 'formatter' => 'moduleTypeId'),
        );
    }
    
    public function getPkField()
    {
        return \Puja\Bob\DbTable\Configure\PageMeta::getInstance()->getPkField();
    }

    public function getActions()
    {
        return array('update', 'delete');
    }
}