<?php
namespace Puja\Bob\Model\Html;

class HtmlLocalize extends \Puja\Bob\Model\Entity\EntityLocalizeAbstract
{
    protected static $recordType = 'content';
    protected function getTable()
    {
        return \Puja\Bob\DbTable\Html\HtmlLn::getInstance();
    }
}