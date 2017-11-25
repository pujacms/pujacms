<?php
namespace Puja\Bob\DbTable\Configure;

class Group extends \Puja\Bob\DbTable\TableAbstract\TableAbstract
{
    protected $tableName = 'configure_group';
    protected $pkField = 'id_configure_group';
    protected static $instanceName = 'configuregroup';
}