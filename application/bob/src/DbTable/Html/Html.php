<?php
namespace Puja\Bob\DbTable\Html;

class Html extends \Puja\Bob\DbTable\Entity\EntityAbstract
{
    protected $tableName = 'html';
    protected $pkField = 'id_html';

    protected function getLnTable()
    {
        return new HtmlLn();
    }
}