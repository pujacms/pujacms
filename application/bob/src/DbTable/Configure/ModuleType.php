<?php
namespace Puja\Bob\DbTable\Configure;

class ModuleType extends \Puja\Bob\DbTable\TableAbstract\TableAbstract
{
    protected $tableName = 'configure_module_type';
    protected $pkField = 'id_configure_module_type';
    protected static $instanceName = 'configuremoduletype';

    public function getByModuleType($moduleType)
    {
        return $this->findOneByCriteria(array('module_type' => $moduleType));
    }
}