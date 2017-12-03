<?php
namespace Puja\Bob\Model\Entity;
use Puja\Bob\DbTable;
abstract class BkEntityLocalizeAbstract extends \Puja\Bob\Model\Entity\EntityAbstract
{
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
        $entityProcessor = Processor\EntityLocalize::getInstance($this->table, $this->cfgModule, static::$recordType);
        return $entityProcessor->getEntityLocalizeByPkId($pkId);
    }

    public function setEntityLocalize($entityId, $entityData)
    {
        $entityProcessor = Processor\EntityLocalize::getInstance($this->table, $this->cfgModule, static::$recordType);
        $entityProcessor->saveLocalize($entityId, $entityData);

        $entityMediaProcessor = Processor\LinkEntityMedia::getInstance($this->table, $this->cfgModule, static::$recordType);
        $entityMediaProcessor->saveLocalize($entityId, $entityProcessor->getUploadedMediaIds());
    }
}