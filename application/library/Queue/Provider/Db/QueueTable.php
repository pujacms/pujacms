<?php
namespace Puja\Library\Queue\Provider\Db;

use Puja\Configure\Configure;
use Puja\Db\Table;

class QueueTable extends Table
{
    public function __construct($tblName = null)
    {
        $tblName = Configure::getInstance('database')->get('table_prefix');
        parent::__construct($tblName);
    }
}