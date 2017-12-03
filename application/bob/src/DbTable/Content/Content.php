<?php
namespace Puja\Bob\DbTable\Content;

class Content extends \Puja\Bob\DbTable\Entity\EntityMultiLnAbstract
{
    protected $tableName = 'content';
    protected $pkField = 'id_content';
    protected $parentField = 'fk_category';
}