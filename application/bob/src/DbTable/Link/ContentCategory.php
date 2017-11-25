<?php
namespace Puja\Bob\DbTable\Link;

class ContentCategory extends \Puja\Bob\DbTable\Entity\LinkAbstract
{
    protected $tableName = 'link_content_category';
    protected $pkField = 'fk_content';
    protected $parentField = 'fk_category';
}