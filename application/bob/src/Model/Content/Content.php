<?php
namespace Puja\Bob\Model\Content;

class Content extends \Puja\Bob\Model\Entity\ContentAbstract
{
    protected static $recordType = 'content';

    protected function getTable()
    {
        $table = \Puja\Bob\DbTable\Content\Content::getInstance();
        $table->setIdConfigureLanguageDefault($this->idConfigureLanguage);
        $table->setTableLocalize($this->getTableLocalize());
        return $table;
    }

    protected function getTableLocalize()
    {
        return \Puja\Bob\DbTable\Content\ContentLn::getInstance();
    }
}