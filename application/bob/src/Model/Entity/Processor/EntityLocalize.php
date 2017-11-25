<?php
namespace Puja\Bob\Model\Entity\Processor;
use Puja\Bob\DbTable;
use Puja\Bob\Model\Constant;

class EntityLocalize extends Entity
{

    public function getEntityLocalizeByPkId($pkId)
    {
        if (empty($this->cfgModule['cfg_data'][$this->recordType]['ln_fields'])) {
            return array();
        }

        $result = $this->table->getByPkId($pkId);

        $entities = array();
        if (!empty($result)) {
            foreach ($result as $rs) {
                $entities[$rs['fk_configure_language']] = $rs;
            }
        }

        $languages = \Puja\Bob\Model\Configure\Language::getInstance()->getActive();
        foreach ($languages as $key => $language) {
            $language['fields'] = $this->prepareEntity(
                empty($entities[$language['id_configure_language']]) ? null : $entities[$language['id_configure_language']],
                $this->cfgModule['cfg_data'][$this->recordType]['ln_fields'],
                Constant::LN_ENTITY . '[' . $language['id_configure_language'] . ']'
            );

            $languages[$key] = $language;
        }
        return $languages;
    }

    public function saveLocalize($entityId, $lnEntities)
    {
        if (empty($this->cfgModule['cfg_data'][$this->recordType]['ln_fields'])) {
            return false;
        }
        foreach ($lnEntities as $idConfigureLanguage => $entityData) {
            $entityData = FormTransfer::getInstance()->convertToDbData(
                $entityData,
                $this->cfgModule['cfg_data'][$this->recordType]['ln_fields'],
                $this->uploadedMediaIds
            );
            $this->table->replace($this->prepareEntityLocalizeInsert($entityData, $entityId, $idConfigureLanguage));
        }
    }

    protected function prepareEntityLocalizeInsert($entityData, $entityId, $idConfigureLanguage)
    {
        $entityData[$this->table->getPkField()] = $entityId;
        $entityData['fk_configure_language'] = $idConfigureLanguage;
        return $entityData;
    }

    /*

    public function getByPkId($pkId)
    {
        return $this->table->getByPkId($pkId);
    }

    public function getLnByPkId($pkId)
    {
        $data = array();
        $result = $this->table->getLnByPkId($pkId);
        while ($rs = $result->fetch()) {
            $data[$rs['locale']] = $rs;
        }

        return $data;
    }

    public function saveMainEntity($entityId, $parentId, $mainEntity)
    {
        $mainEntity = $this->setEntity(
            $mainEntity,
            empty($this->cfgModule['cfg_data'][$this->recordType]['main_fields']) ? array() : $this->cfgModule['cfg_data'][$this->recordType]['main_fields']
        );

        if ($entityId) {
            if (empty($mainEntity)) {
                return $entityId;
            }
            $this->getTable()->updateByPkId($mainEntity, $entityId);
        } else {
            $this->getTable()->updateCurrentOrderIdByParentId($parentId);
            $entityId = $this->getTable()->insertEntity($mainEntity, $this->typeId, $parentId);
            $this->saveLinkCategories(
                $parentId,
                $entityId
            );

        }

        $this->saveDynamicOptions($entityId);
        return $entityId;
    }

    public function saveLnEntity($entityId, $lnEntity)
    {
        foreach ($lnEntity as $locale => $entityData) {
            $entityData = $this->setEntity(
                $entityData,
                $this->cfgModule['cfg_data'][$this->recordType]['ln_fields']
            );

            $this->getTable()->replaceByPkIdAndLocale($entityData, $entityId, $locale);
        }
    }

    protected function setEntity($entityData, $entityCfg)
    {
        if (empty($entityData)) {
            return array();
        }

        foreach ($entityData as $field => $value) {
            if (empty($entityCfg[$field])) {
                continue;
            }

            $entityData[$field] = Transfer::setValue(
                $entityCfg[$field],
                $value
            );

            if ($entityCfg[$field]['field_type'] == 'dynamic_option') {
                $this->dynamicOptions[$field] = $value;
            }
        }

        return $entityData;
    }



    public function getLnEntity($pkId)
    {
        $languages = Language::getInstance()->getActive();
        $lngEntity = $this->getLnByPkId($pkId);
        foreach ($languages as $key => $language) {
            $languages[$key]['fields'] = $this->getEntity(
                empty($lngEntity[$language['locale']]) ? array() : $lngEntity[$language['locale']],
                $this->cfgModule['cfg_data'][$this->recordType]['ln_fields'],
                'LnEntity[' . $language['locale'] . ']'
            );
        }

        return $languages;
    }



    protected function saveDynamicOptions($pkId)
    {
        return;
    }

    protected function saveLinkCategories($categoryId, $contentId)
    {
        return;
    }








    public function getEntities()
    {
        return $this->getTable()->getEntityByTypeId($this->typeId);
    }

    public function getSearchEntities($excludeIds, $q)
    {
        return $this->getTable()->getEntityByTypeIdAndExcludeIdsAndSearchParam($this->typeId, $excludeIds, $q);
    }

    */
}