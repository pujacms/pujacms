<?php
namespace Puja\Bob\DbTable\TableAbstract;

abstract class MultiLnTableAbstract extends TableAbstract
{
    /**
     * @var TableLocalizeAbstract
     */
    protected $lnTable;

    public function __construct($tableName = null)
    {
        var_dump('1111');exit;
        parent::__construct($tableName);
        $this->lnTable = $this->getLnTable();
    }

    abstract protected function getLnTable();
    public function updateCurrentOrderIdByParentId($parentId)
    {
        $this->updateByCriteria(
            array('order_id__exact' => 'order_id+1'),
            array($this->parentField => $parentId)
        );
    }

    
    /*
    public function getEntityByPkIds($pkIds)
    {
        $adapter = self::getAdapter();
        $select = $adapter->select()->from(
            array($this->shortTableName => $this->tableName), array('pkid' => $this->pkField, '*')
        )->where('%s.%s IN(%s)', $this->shortTableName, $this->pkField, implode(',', $pkIds));

        if ($this->shortLnTableName) {
            $select->joinInner(
                array($this->shortLnTableName => $this->lnTableName),
                sprintf('%s.%s=%s.%s AND %s.locale="%s"', $this->shortTableName, $this->pkField, $this->shortLnTableName, $this->pkField, $this->shortLnTableName, 'vi')
            );
        }
        
        $result = $adapter->query($select);
        return $result->fetchAll();
    }

    public function getEntityByTypeId($typeId)
    {
        $adapter = self::getAdapter();
        $select = $adapter->select()->from(
            array($this->shortTableName => $this->tableName), array('pkid' => $this->pkField, '*')
        )->where('%s.%s=%d', $this->shortTableName, 'type_id', $typeId);

        if ($this->shortLnTableName) {
            $select->joinInner(
                array($this->shortLnTableName => $this->lnTableName),
                sprintf('%s.%s=%s.%s AND %s.locale="%s"', $this->shortTableName, $this->pkField, $this->shortLnTableName, $this->pkField, $this->shortLnTableName, 'vi')
            );
        }

        $result = $adapter->query($select);
        return $result->fetchAll();
    }

    public function getEntityByTypeIdAndExcludeIdsAndSearchParam($typeId, $excludeIds, $q = null)
    {
        $adapter = self::getAdapter();
        $select = $adapter->select()->from(
            array($this->shortTableName => $this->tableName), array('pkid' => $this->pkField, '*')
        )->where('%s.%s=%d', $this->shortTableName, 'type_id', $typeId);
        if ($excludeIds) {
            $select->where('%s.%s NOT IN(%s)', $this->shortTableName, $this->pkField, $excludeIds);
        }

        if ($this->shortLnTableName) {
            $select->joinInner(
                array($this->shortLnTableName => $this->lnTableName),
                sprintf('%s.%s=%s.%s AND %s.locale="%s"', $this->shortTableName, $this->pkField, $this->shortLnTableName, $this->pkField, $this->shortLnTableName, 'vi')
            );

            if ($q) {
                $select->where('%s.name LIKE "%%%s%%"', $this->shortLnTableName, $q);
            }
        }

        $result = $adapter->query($select);
        return $result->fetchAll();
    }

    public function getLnByPkId($pkId)
    {
        $adapter = self::getAdapter();
        $select = $adapter->select()->from(array($this->shortLnTableName => $this->lnTableName));
        $select->where($this->pkField . '=%d', $pkId);
        return $adapter->query($select);

    }

    public function replaceByPkIdAndLocale($data, $pkId, $locale)
    {
        $data[$this->pkField] = $pkId;
        $data['locale'] = $locale;
        $adapter = self::getWriteAdapter();
        $adapter->replace($this->lnTableName, $data);
    }



    public function insertEntity(array $insertFields, $typeId, $parentId = 0, $status = 1)
    {
        $insertFields['type_id'] = $typeId;
        $insertFields[$this->parentField] = $parentId;
        $insertFields['status'] = $status;
        $insertFields['order_id'] = 0;
        $insertFields['addtime__exact'] = 'NOW()';
        return parent::insert($insertFields, false);
    }

    public function getByPkId($pkId)
    {
        $data = parent::getByPkId($pkId);
        if (empty($data)) {
            return $data;
        }

        $data['pkid'] = $data[$this->pkField];
        if ($this->parentField) {
            $data['parentid'] = $data[$this->parentField];
        }

        return $data;
    }
    */
}