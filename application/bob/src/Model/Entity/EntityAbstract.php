<?php
namespace Puja\Bob\Model\Entity;
use Puja\Bob\DbTable;
abstract class EntityAbstract extends \Puja\Bob\Model\AbstractLayer\BaseAbstract
{
    /**
     * @var DbTable\Entity\EntityAbstract
     */
    protected $table;

    /**
     * @var EntityLocalize
     */
    protected $localizeModel;

    protected $idConfigureModule;
    protected $idConfigureLanguage;
    protected $cfgModule;
    protected static $recordType;


    protected function getTableLocalize(){}
    public static function getInstance($idConfigureModule, $cfgModule = null, $idConfigureLanguage = null)
    {
        if (empty(static::$modelName)) {
            return new static($idConfigureModule, $cfgModule, $idConfigureLanguage);
        }

        if (empty(static::$instances[static::$modelName])) {
            static::$instances[static::$modelName] = new static($idConfigureModule, $cfgModule, $idConfigureLanguage);
        }

        return static::$instances[static::$modelName];
    }

    protected function __construct($idConfigureModule, $cfgModule = null, $idConfigureLanguage = null)
    {
        $this->idConfigureModule = $idConfigureModule;
        $this->cfgModule = $cfgModule;
        $this->idConfigureLanguage = $idConfigureLanguage;
        if (null !== $idConfigureLanguage) {
            $tableLocalize = $this->getTableLocalize();
            if (null === $tableLocalize) {
                throw new \Exception('TableLn must NOT empty');
            }

            $this->localizeModel = EntityLocalize::getInstance($tableLocalize, $this->cfgModule, static::$recordType);
        }

        parent::__construct();
    }

    /**
     * @return  EntityLocalize
     */
    public function getLocalizeModel()
    {
        return $this->localizeModel;
    }

    public function getRecordType()
    {
        return static::$recordType;
    }

    public function getUnionQuery($parentId, $cond, $orderBy = null, $page = 0, $limit = 0)
    {
        $offset = $page * $limit;
        return $this->table->getUnionQuery($this->recordType, $this->idConfigureModule, $parentId, $cond, $orderBy, $offset, $limit);
    }

    public function setEntity($entityId, $parentId, $entityData, $parents = null)
    {
        $isInsert = empty($entityId);

        $entityProcessor = Processor\Entity::getInstance($this->table, $this->cfgModule, static::$recordType);
        $entityId = $entityProcessor->save($entityId, $parentId, $entityData);
        
        $entityMediaProcessor = Processor\LinkEntityMedia::getInstance($this->table, $this->cfgModule, static::$recordType);
        $entityMediaProcessor->save($entityId, $entityProcessor->getUploadedMediaIds());
        
        if ($isInsert) {
            $linkContentCategory = Processor\LinkContentCategory::getInstance($this->table, $this->cfgModule, static::$recordType);
            $linkContentCategory->save($entityId, $parentId, $parents);
        }

        $linkContentContent = Processor\LinkContentContent::getInstance($this->table, $this->cfgModule, static::$recordType);
        $linkContentContent->save($entityId, $parentId, $parents);


        return $entityId;

    }

    public function updateLinkCategory($pkId,  $parentId, $parents = null)
    {
        $linkContentCategory = Processor\LinkContentCategory::getInstance($this->table, $this->cfgModule, static::$recordType);
        $linkContentCategory->updateParentIdByPkId($pkId,  $parentId, $parents);
    }

    public function getEntityByPkId($pkId)
    {
        $entityProcessor = Processor\Entity::getInstance($this->table, $this->cfgModule, static::$recordType);
        return $entityProcessor->getEntityByPkId($pkId);
    }

    public function getList($parentId = null, $query = null, $orderBy = null, $page = 0, $limit = 0)
    {
        $data = parent::getList($parentId, $query, $orderBy, $page, $limit);
        if (empty($data['rows'])) {
            return $data;
        }

        foreach ($data['rows'] as $key => $row) {
            $row['pkid'] = $row[$this->table->getPkField()];
            $row['parentId'] = $row[$this->table->getParentField()];
            $row['recordType'] = static::$recordType;
            $data['rows'][$key] = $row;
        }

        return $data;
    }

    protected function getCondByParentId($parentId)
    {
        if (null === $parentId) {
            return '1';
        }

        return $this->table->getParentField() . '=' . (int) $parentId;

    }

    public function updateOrders($orderData)
    {
        foreach ($orderData as $orderId => $pkId) {
            $this->table->updateByPkId(array('order_id' => $orderId), $pkId);
        }
    }
}