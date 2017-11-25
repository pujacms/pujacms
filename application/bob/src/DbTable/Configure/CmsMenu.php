<?php
namespace Puja\Bob\DbTable\Configure;

class CmsMenu extends \Puja\Bob\DbTable\TableAbstract\TableAbstract
{
    protected $tableName = 'configure_cmsmenu';
    protected $pkField = 'id_configure_cmsmenu';
    protected static $instanceName = 'configurecmsmenu';

    public function getAll()
    {
        return $this->findByCriteria('1', 'order_id');
    }
}