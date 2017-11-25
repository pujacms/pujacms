<?php
namespace Puja\Bob\Model\Content;

class ContentLocalize extends \Puja\Bob\Model\Entity\EntityLocalizeAbstract
{

    protected static $recordType = 'content';
    protected function getTable()
    {
        return \Puja\Bob\DbTable\Content\ContentLn::getInstance();
    }
}