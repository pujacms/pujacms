<?php
namespace Puja\Bob\Model\Entity\Processor;
use Puja\Bob\DbTable;
abstract class ProcessorAbstract
{
    protected $table;
    protected $cfgModule;
    protected $recordType;
    protected static $instanceName;
    protected static $instances;

    public static function getInstance(DbTable\TableAbstract\TableAbstract $table, $cfgModule, $recordType)
    {
        if (null == static::$instanceName) {
            return new static($table, $cfgModule, $recordType);
        }

        if (empty(static::$instances[static::$instanceName])) {
            static::$instances[static::$instanceName] = new static($table, $cfgModule, $recordType);
        }

        return static::$instances[static::$instanceName];
    }

    protected function __construct(DbTable\TableAbstract\TableAbstract $table, $cfgModule, $recordType)
    {
        $this->table = $table;
        $this->cfgModule = $cfgModule;
        $this->recordType = $recordType;
    }
}