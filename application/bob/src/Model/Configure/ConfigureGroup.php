<?php
namespace Puja\Bob\Model\Configure;
use Puja\Bob\DbTable;

class ConfigureGroup extends \Puja\Bob\Model\AbstractLayer\ModelAbstract
{
    protected function getTable()
    {
        return DbTable\Configure\Group::getInstance();
    }

    protected function getCondByParentId($parentId)
    {

        if ($parentId) {
            return 'configure_group_id=' . (int) $parentId;
        }

        return '1';
    }
}