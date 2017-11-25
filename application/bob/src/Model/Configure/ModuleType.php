<?php
namespace Puja\Bob\Model\Configure;
use Puja\Bob\DbTable;
class ModuleType extends \Puja\Bob\Model\AbstractLayer\ModelAbstract
{
    protected static $modelName = 'Configure_ModuleType';
    protected function getTable()
    {
        return DbTable\Configure\ModuleType::getInstance();
    }

    public function getByModuleType($moduleType)
    {
        return $this->getTable()->findOneByCriteria(array('module_type' => $moduleType));
    }
}