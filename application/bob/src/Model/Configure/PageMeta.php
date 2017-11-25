<?php
namespace Puja\Bob\Model\Configure;
use Puja\Bob\DbTable;

class PageMeta extends \Puja\Bob\Model\AbstractLayer\ModelAbstract
{
    protected static $modelName = 'Configure_PageMeta';
    protected function getTable()
    {
        return DbTable\Configure\PageMeta::getInstance();
    }
}