<?php
namespace Puja\Bob\DbTable\Link;

class EntityMedia extends \Puja\Bob\DbTable\Entity\LinkAbstract
{
    protected $tableName = 'link_entity_media';
    protected $pkField = 'fk_entity';
    protected $parentField = 'fk_media';


    public function getRecordTypeField()
    {
        return 'record_type';
    }
}