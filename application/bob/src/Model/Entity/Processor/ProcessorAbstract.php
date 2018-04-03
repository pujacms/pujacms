<?php
namespace Puja\Bob\Model\Entity\Processor;
use Puja\Bob\DbTable;
abstract class ProcessorAbstract
{
    protected $table;
    protected $cfgModule;
    protected $recordType;
    protected $level;
    protected static $instanceName;
    protected static $instances;

    public static function getInstance(DbTable\TableAbstract\TableAbstract $table, $cfgModule, $recordType, $level = -1)
    {
        if (null == static::$instanceName) {
            return new static($table, $cfgModule, $recordType, $level);
        }

        if (empty(static::$instances[static::$instanceName])) {
            static::$instances[static::$instanceName] = new static($table, $cfgModule, $recordType, $level);
        }

        return static::$instances[static::$instanceName];
    }

    protected function __construct(DbTable\TableAbstract\TableAbstract $table, $cfgModule, $recordType, $level)
    {
        $this->table = $table;
        $this->cfgModule = $cfgModule;
        $this->recordType = $recordType;
        $this->level = $level;
    }
}