<?php
namespace Puja\Bob\Model\Configure;
use Puja\Bob\DbTable;
class Language extends \Puja\Bob\Model\AbstractLayer\ModelAbstract
{
    protected function getTable()
    {
        return DbTable\Configure\Language::getInstance();
    }
}