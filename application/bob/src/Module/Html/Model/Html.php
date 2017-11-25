<?php
namespace Puja\Bob\Module\Html\Model;

class Html extends \Puja\Bob\Module\Entity\Model\Entity
{
    protected function getContentModel()
    {
        return new Content($this->typeId);
    }

    protected function getCategoryModel()
    {
        return null;
    }
}