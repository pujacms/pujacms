<?php
namespace Puja\Bob\Model\Category;

class Category extends \Puja\Bob\Model\Entity\CategoryAbstract
{
    protected static $recordType = 'category';

    protected function getTable()
    {
        $table = \Puja\Bob\DbTable\Category\Category::getInstance();
        $table->setIdConfigureLanguageDefault($this->idConfigureLanguage);
        return $table;
    }
}