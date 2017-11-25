<?php
namespace Puja\Bob\Service;
use Puja\Bob\Model\Configure;
class ModuleType extends ServiceAbstract
{
    public function getAll()
    {
        $model = Configure\ModuleType::getInstance();
        $moduleTypes = array();
        foreach ($model->getAll() as $row) {
            $moduleTypes[$row['id_configure_module_type']] = $row;
        }

        return $moduleTypes;
    }

    public function getByModuleType($moduleType)
    {
        $model = Configure\ModuleType::getInstance();
        return $model->getByModuleType($moduleType);
    }
}