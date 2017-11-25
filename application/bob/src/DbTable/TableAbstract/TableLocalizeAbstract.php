<?php
namespace Puja\Bob\DbTable\TableAbstract;
use Puja\Db\Table;

abstract class TableLocalizeAbstract extends TableAbstract
{
    private $localeField = 'fk_configure_language';


    public function getLocaleField()
    {
        return $this->localeField;
    }
}