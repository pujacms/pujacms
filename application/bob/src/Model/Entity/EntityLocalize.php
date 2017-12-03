<?php
namespace Puja\Bob\Model\Entity;
use Puja\Bob\DbTable;
class EntityLocalize
{
    /**
     * @var \Puja\Bob\DbTable\Entity\EntityLocalizeAbstract
     */
    protected $table;
    protected $cfgModule;
    protected $recordType;

    protected static $instances;

    /**
     * @param DbTable\Entity\EntityLocalizeAbstract $table
     * @return static
     */
    public static function getInstance(\Puja\Bob\DbTable\Entity\EntityLocalizeAbstract $table, $cfgModule = null, $recordType = null)
    {
        $tblName = $table->getTableName();
        if (empty(static::$instances[$tblName])) {
            static::$instances[$tblName] = new static($table, $cfgModule, $recordType);
        }

        return static::$instances[$tblName];
    }

    protected function __construct(\Puja\Bob\DbTable\Entity\EntityLocalizeAbstract $table, $cfgModule = null, $recordType = null)
    {
        $this->table = $table;
        $this->cfgModule = $cfgModule;
        $this->recordType = $recordType;
    }

    public function getByPkId($pkId)
    {
        return $this->table->findByCriteria(array(
            $this->table->getPkField() => $pkId
        ));
    }

    public function getByPkIdAndIdLanguage($pkId, $idLanguage)
    {
        return $this->table->findByCriteria(array(
            $this->table->getPkField() => $pkId,
            'id_configure_language' => $idLanguage,
        ));
    }

    public function getEntityByPkId($pkId)
    {
        $entityProcessor = Processor\EntityLocalize::getInstance($this->table, $this->cfgModule, $this->recordType);
        return $entityProcessor->getEntityLocalizeByPkId($pkId);
    }

    public function setEntityLocalize($entityId, $entityData)
    {
        $entityProcessor = Processor\EntityLocalize::getInstance($this->table, $this->cfgModule, $this->recordType);
        $entityProcessor->saveLocalize($entityId, $entityData);

        $entityMediaProcessor = Processor\LinkEntityMedia::getInstance($this->table, $this->cfgModule, $this->recordType);
        $entityMediaProcessor->saveLocalize($entityId, $entityProcessor->getUploadedMediaIds());
    }
}