<?php
namespace Puja\Bob\DbTable\Entity;

abstract class EntityAbstract extends \Puja\Bob\DbTable\TableAbstract\TableAbstract
{
    protected $parentField;

    public function getParentField()
    {
        return $this->parentField;
    }

    protected function getUnionFields($recordType)
    {
        return array(
            'pkid' => $this->pkField,
            'parentId' => $this->parentField,
            'recordType__exact' => '"' . $recordType . '"',
            'order_id',
            'status',
            'created_at',
            'fk_configure_module',
            'name' => 'name'
        );
    }

    public function getUnionQuery($recordType, $configureModuleId, $parentId = -1, $additionCond = null, $orderBy = null, $offset = 0, $limit = 0)
    {
        $adapter = self::getAdapter();
        $select = $adapter->select()->from(array($this->shortTableName => $this->tableName), $this->getUnionFields($recordType))
            ->where('%s.fk_configure_module=%d', $this->shortTableName, $configureModuleId);

        if ($parentId >= 0) {
            $select->where('%s.%s=%d', $this->shortTableName, $this->parentField, $parentId);
        }
        
        if ($additionCond) {
            $select->where($additionCond);
        }


        return $select;
    }

    public function updateExistedOrderIdByParentId($parentId)
    {
        $this->updateByCriteria(
            array('order_id__exact' => 'order_id+1'),
            array($this->parentField => $parentId)
        );
    }
}