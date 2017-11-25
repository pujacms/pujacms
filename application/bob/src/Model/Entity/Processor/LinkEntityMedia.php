<?php
namespace Puja\Bob\Model\Entity\Processor;
use Puja\Bob\DbTable;

class LinkEntityMedia extends ProcessorAbstract
{
    /**
     * @var DbTable\Entity\LinkAbstract
     */
    protected $table;

    public function save($entityId, $mediaIds)
    {
        if (empty($entityId)) {
            return false;
        }

        $linkTable = $this->getLinkTable();
        if (null === $linkTable) {
            return false;
        }

        $mediaTable = DbTable\Media\Media::getInstance();

        $result = $linkTable->findByCriteria(array(
            $linkTable->getRecordTypeField() => $this->recordType,
            $linkTable->getPkField() => $entityId,
        ));

        $currentMediaIds = array();
        foreach ($result as $rs) {
            $currentMediaIds[] = $rs[$linkTable->getParentField()];
        }


        $linkTable->deleteByCriteria(array(
            $linkTable->getRecordTypeField() => $this->recordType,
            $linkTable->getPkField() => $entityId
        ));


        if (!empty($currentMediaIds)) {
            $mediaTable->updateByCriteria(array('is_used' => 0), array(
                'id_media__in' => implode(',', $currentMediaIds)
            ));
        }

        if (empty($mediaIds)) {
            return false;
        }

        $mediaIds = array_unique($mediaIds);

        foreach ($mediaIds as $mediaId) {
            $linkTable->insert(array(
                $linkTable->getRecordTypeField() => $this->recordType,
                $linkTable->getPkField() => $entityId,
                $linkTable->getParentField() => $mediaId,
            ));
        }

        $mediaTable->updateByCriteria(array('is_used' => 1), array(
            'id_media__in' => implode(',', $mediaIds)
        ));

        return true;
    }

    public function saveLocalize($entityId, $mediaIds)
    {
        if (empty($mediaIds)) {
            return false;
        }

        $linkTable = $this->getLinkTable();
        if (null === $linkTable) {
            return false;
        }

        $mediaTable = DbTable\Media\Media::getInstance();
        foreach ($mediaIds as $mediaId) {
            $linkTable->insert(array(
                $linkTable->getRecordTypeField() => $this->recordType,
                $linkTable->getPkField() => $entityId,
                $linkTable->getParentField() => $mediaId,
            ));
        }

        $mediaTable->updateByCriteria(array('is_used' => 1), array(
            'id_media__in' => implode(',', $mediaIds)
        ));
    }


    protected function getLinkTable()
    {
        if ($this->cfgModule['module_type'] != 'entity' && $this->cfgModule['module_type'] != 'customize' && $this->cfgModule['module_type'] != 'html') {
            return null;
        }

        if ($this->cfgModule['module_type'] == 'entity') {
            return DbTable\Link\EntityMedia::getInstance();
        }

        if ($this->cfgModule['module_type'] == 'html') {
            return DbTable\Link\HtmlEntityMedia::getInstance();
        }

        if ($this->cfgModule['module_type'] == 'customize') {
            $table = DbTable\Link\EntityMedia::getInstance($this->cfgModule['core_data']['content']['tbl']['name'] . '_link_media');
            $table->setPkField('fk_' . $this->cfgModule['core_data']['content']['tbl']['name']);
            $table->setParentField('fk_media');
            return $table;
        }

        return null;
    }


    public function getByPkId($pkId)
    {
        $mediaIds = array();
        $linkTable = $this->getLinkTable();
        $result = $linkTable->findByCriteria(array(
            $linkTable->getRecordTypeField() => $this->recordType,
            $linkTable->getPkField() => $pkId,
        ));

        foreach ($result as $rs) {
            $mediaIds[$rs[$linkTable->getParentField()]] = $pkId;
        }

        return $mediaIds;
    }
}