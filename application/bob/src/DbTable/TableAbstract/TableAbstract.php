<?php
namespace Puja\Bob\DbTable\TableAbstract;
use Puja\Configure;
abstract class TableAbstract extends \Puja\Db\Table
{
    
    protected $shortTableName;
    protected $pkField;
    protected static $instances;
    protected static $instanceName;

    /**
     * @param null $tableName
     * @return static
     */
    public static function getInstance($tableName = null)
    {
        if (empty(static::$instanceName)) {
            return new static($tableName);
        }

        if (empty(static::$instances[static::$instanceName])) {
            static::$instances[static::$instanceName] = new static($tableName);
        }

        return static::$instances[static::$instanceName];

    }

    public function __construct($tableName = null)
    {
        if ($tableName) {
            $this->tableName = $tableName;
        }

        $this->shortTableName = $this->tableName;
        $this->tableName = Configure\Configure::getInstance('database')->get('table_prefix') . $this->tableName;
    }

    public function getPkField()
    {
        return $this->pkField;
    }

    public function getByPkId($pkId)
    {
        return $this->findOneByCriteria(array($this->pkField => $pkId));
    }

    public function updateByPkId($data, $pkId)
    {
        $this->updateByCriteria($data, array($this->pkField . '__int' => $pkId));
    }

    public function deleteByPkId($pkId)
    {
        $this->deleteByCriteria(array($this->pkField . '__int' => $pkId));
    }

    public function toggleStatusByPkId($pkId)
    {
        $this->updateByCriteria(array('status__exact' => 'ABS(status - 1)'), array($this->pkField . '__int' => $pkId));
    }

    public function getShortTableName()
    {
        return $this->shortTableName;
    }

    protected function getFindByCriteriaBuilder($criteria, $orderBy =  null, $offset = 0, $limit = 0)
    {
        $adapter = self::getAdapter();
        $select = $adapter->select()->from(array($this->shortTableName => $this->tableName))->where($criteria);
        if ($orderBy) {
            $select->order($orderBy);
        }
        if ($limit) {
            $select->limit($offset, $limit);
        }
        return $select;
    }

    public function findByCriteria($criteria, $orderBy =  null, $offset = 0, $limit = 0)
    {
        $adapter = self::getAdapter();
        $result = $adapter->query(
            $this->getFindByCriteriaBuilder($criteria, $orderBy, $offset, $limit)
        );
        return $result->fetchAll();
    }

    public function findOneByCriteria($criteria)
    {
        $adapter = self::getAdapter();
        $select = $this->getFindByCriteriaBuilder($criteria);
        $result = $adapter->query($select->getQuery());
        return $result->fetch();
    }

    public function getCountByCriteria($criteria)
    {
        $adapter = self::getAdapter();
        $select = $this->getFindByCriteriaBuilder($criteria);
        $result = $adapter->query($select->getCount());
        return $result->fetchColumn();
    }

    public function getAll()
    {
        return $this->findByCriteria('1');
    }

    
}