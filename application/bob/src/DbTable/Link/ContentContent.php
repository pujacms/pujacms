<?php
namespace Puja\Bob\DbTable\Link;

class ContentContent extends \Puja\Bob\DbTable\Entity\LinkAbstract
{
    protected $tableName = 'link_content_content';
    protected static $instanceName = 'link_content_content';
    protected $pkField = 'fk_content';
    protected $parentField = '	target_fk_content';
}