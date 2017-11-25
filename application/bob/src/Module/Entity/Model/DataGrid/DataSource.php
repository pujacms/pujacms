<?php
namespace Puja\Bob\Module\Entity\Model\DataGrid;
use Puja\Bob\DbTable;


class DataSource extends \Puja\Bob\Model\DataGrid\Entity\DataSourceAbstract
{
    protected function getCategoryTable()
    {
        $table = \Puja\Bob\DbTable\Category\Category::getInstance();
        $table->setIdConfigureLanguageDefault($this->idConfigureLanguage);
        return $table;

    }

    protected function getContentTable()
    {
        $table = \Puja\Bob\DbTable\Content\Content::getInstance();
        $table->setIdConfigureLanguageDefault($this->idConfigureLanguage);
        return $table;
    }
}