<?php
namespace Puja\Bob\Model\AbstractLayer;
use Puja\Bob\DbTable;
abstract class BaseAbstract
{
    /**
     * @var DbTable\TableAbstract\TableAbstract
     */
    protected $table;
    protected static $instances;
    protected static $modelName;
    abstract protected function getTable();

    protected function __construct()
    {
        $this->table = $this->getTable();
    }

    public function getAll()
    {
        return $this->table->findByCriteria('1', 'order_id');
    }

    public function getActive()
    {
        return $this->table->findByCriteria('status=1', 'order_id');
    }

    public function update($data, $pkId = 0)
    {
        if (empty($data)) {
            return false;
        }

        if ($pkId) {
            return $this->updateByPkId($data, $pkId);
        }

        return $this->table->insert($data);
    }

    

    public function updateByPkId($data, $pkId)
    {
        $this->table->updateByPkId($data, $pkId);
    }

    public function deleteByPkId($pkId)
    {
        $this->table->deleteByPkId($pkId);
    }

    public function toggleStatusByPkId($pkId)
    {
        $this->table->toggleStatusByPkId($pkId);
    }

    public function getByPkId($pkId)
    {
        return $this->table->getByPkId($pkId);
    }

    public function getByPkIds($pkIds)
    {
        if (empty($pkIds)) {
            return array();
        }

        $result = $this->table->findByCriteria(array(
            $this->table->getPkField() . '__in' => implode(',', $pkIds)
        ));

        $data = array();
        foreach ($result as $rs) {
            $data[$rs[$this->table->getPkField()]] = $rs;
        }

        return $data;
    }

    public function getList($parentId = null, $query = null, $orderBy = null, $page = 0, $limit = 0)
    {
        $cond = $this->getCondByParentId($parentId);
        return array(
            'rows' => $this->table->findByCriteria($cond, $orderBy, $page * $limit, $limit),
            'total' => $this->table->getCountByCriteria($cond)
        );
    }

    protected function getCondByParentId($parentId)
    {
        return '1';
    }
    
}