<?php
namespace Puja\Bob\Model\Content;

class Content extends \Puja\Bob\Model\Entity\ContentAbstract
{
    protected static $recordType = 'content';

    protected function getTable()
    {
        $table = \Puja\Bob\DbTable\Content\Content::getInstance();
        $table->setIdConfigureLanguageDefault($this->idConfigureLanguage);
        return $table;
    }
}