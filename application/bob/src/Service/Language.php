<?php
namespace Puja\Bob\Service;
class Language extends ServiceAbstract
{
    public function getActive()
    {
        $model = \Puja\Bob\Model\Configure\Language::getInstance();
        return $model->getActive();
    }
}