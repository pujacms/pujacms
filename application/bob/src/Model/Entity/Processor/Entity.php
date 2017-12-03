<?php
namespace Puja\Bob\Model\Entity\Processor;
use Puja\Bob\DbTable;
use Puja\Bob\Model\Constant;

class Entity extends ProcessorAbstract
{
    /**
     * @var DbTable\Entity\EntityAbstract
     */
    protected $table;
    protected $uploadedMediaIds = array();

    public function getUploadedMediaIds()
    {
        return $this->uploadedMediaIds;
    }

    
    public function save($entityId, $parentId, $entityData)
    {
        if (empty($entityData) && $entityId) {
            return $entityId;
        }

        /* @TODO: check current data before save
        if ($entityId) {
            $currentEntity = $this->table->getByPkId($entityId);
        }*/


        if (!empty($this->cfgModule['cfg_data'][$this->recordType]['main_fields'])) {
            $entityData = FormTransfer::getInstance()->convertToDbData(
                $entityData,
                $this->cfgModule['cfg_data'][$this->recordType]['main_fields'],
                $this->uploadedMediaIds
            );
        }
        
        if ($entityId) {
            $this->table->updateByPkId($entityData, $entityId);
        } else {
            $this->table->updateExistedOrderIdByParentId($parentId);
            $entityId = $this->table->insert(
                $this->prepareEntityInsert($entityData, $parentId)
            );
        }

        //$this->saveDynamicOptions($entityId);
        return $entityId;
    }

    protected function getCurrentMediaByPkId($pkId)
    {
        $entityMediaProcessor = LinkEntityMedia::getInstance($this->table, $this->cfgModule, $this->recordType);
        $entityMediaData = $entityMediaProcessor->getByPkId($pkId);
        return \Puja\Bob\Model\Media\Media::getInstance()->getByPkIds(array_keys($entityMediaData));

    }

    public function getEntityByPkId($pkId)
    {
        if (empty($this->cfgModule['cfg_data'][$this->recordType]['main_fields'])) {
            return array();
        }
        
        $entityData = $this->table->findOneByCriteria(array(
            $this->table->getPkField() => $pkId,
        ));
        return array(
            'fields' => $this->prepareEntity(
                $entityData,
                $this->cfgModule['cfg_data'][$this->recordType]['main_fields'],
                Constant::MAIN_ENTITY
            )
        );

    }

    protected function prepareEntity($entityData, $entityCfg, $inputFieldName, $dynamicOptions = array())
    {
        if (empty($entityData)) {
            $entityData = array();
        }

        $currentMedia = array();

        if (!empty($entityData[$this->table->getPkField()])) {
            $currentMedia = $this->getCurrentMediaByPkId($entityData[$this->table->getPkField()]);
        }

        $result = array();
        $originalIndex = 0;
        foreach ($entityCfg as $field => $cfg) {
            if (empty($cfg['checked'])) {
                continue;
            }
            $cfg['originalIndex'] = $originalIndex++;
            $cfg['InputFieldName'] = $inputFieldName . '[' . $field . ']';
            $cfg['value'] = FormTransfer::getInstance()->convertToHtmlData($field, $cfg, $entityData, $currentMedia, $dynamicOptions);
            $cfg['Field'] = $field;
            /*if (!empty($cfg['setting']['dynamic_option'])) {
                $cfg['setting']['dynamic_option_module_type_id'] = $modules[$cfg['setting']['dynamic_option']]['module_type_id'];
                $cfg['setting']['dynamic_option_type_id'] = $modules[$cfg['setting']['dynamic_option']]['type_id'];
            }*/
            $result[$field] = $cfg;
        }

        uasort($result, array($this, 'reOrderEntitySetting'));
        return $result;
    }


    protected function reOrderEntitySetting($a, $b)
    {
        if ($a['indexed'] == $b['indexed']) {
            return $a['originalIndex'] > $b['originalIndex'];
        }
        return $a['indexed'] > $b['indexed'];
    }

    protected function prepareEntityInsert($entityData, $parentId)
    {
        $entityData['fk_configure_module'] = $this->cfgModule['id_configure_module'];
        if ($this->table->getParentField()) {
            $entityData[$this->table->getParentField()] = $parentId;
        }
        $entityData['status'] = Constant::STATUS_ACTIVE;
        $entityData['order_id'] = Constant::ORDER_ID_DEFAULT;
        return $entityData;
    }
}