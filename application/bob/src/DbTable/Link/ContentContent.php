<?php
namespace Puja\Bob\DbTable\Link;

class ContentContent extends \Puja\Bob\DbTable\Entity\LinkAbstract
{
    protected $tableName = 'link_content_category';
    protected static $instanceName = 'link_content_category';
    protected $pkField = 'fk_content';
    protected $parentField = 'fk_category';
}