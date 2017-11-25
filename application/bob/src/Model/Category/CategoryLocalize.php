<?php
namespace Puja\Bob\Model\Category;

class CategoryLocalize extends \Puja\Bob\Model\Entity\EntityLocalizeAbstract
{

    protected static $recordType = 'category';
    protected function getTable()
    {
        return \Puja\Bob\DbTable\Category\CategoryLn::getInstance();
    }
}