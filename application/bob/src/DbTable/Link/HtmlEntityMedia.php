<?php
namespace Puja\Bob\DbTable\Link;

class HtmlEntityMedia extends \Puja\Bob\DbTable\Entity\LinkAbstract
{
    protected $tableName = 'html_link_entity_media';
    protected $pkField = 'fk_html';
    protected $parentField = 'fk_media';


    public function getRecordTypeField()
    {
        return 'record_type';
    }
}