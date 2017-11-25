<?php
namespace Puja\Bob\Service;
class Module extends ServiceAbstract
{
    public function getByModuleTypeIdAndTypeId($moduleTypeId, $typeId)
    {
        $model = \Puja\Bob\Model\Configure\Module::getInstance();
        return $model->getByModuleTypeIdAndTypeId($moduleTypeId, $typeId);
    }

    public function getTypeIds()
    {
        $model = \Puja\Bob\Model\Configure\Module::getInstance();
        return $model->getTypeIds();
    }

    public function getAll()
    {
        return \Puja\Bob\Model\Configure\Module::getInstance()->getAll();
    }
}