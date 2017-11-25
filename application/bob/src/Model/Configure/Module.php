<?php
namespace Puja\Bob\Model\Configure;
use Puja\Bob\DbTable;

class Module extends \Puja\Bob\Model\AbstractLayer\ModelAbstract
{
    protected static $modelName = 'Configure_Module';
    protected function getTable()
    {
        return DbTable\Configure\Module::getInstance();
    }

    public function getAll($fields = array())
    {
        $data = $this->getTable()->getAll();
        $pkField = $this->table->getPkField();
        foreach ($data as $key => $rs) {
            if ($fields) {
                $data[$rs[$pkField]] = array_intersect_key($rs, $fields);
            } else {
                $data[$rs[$pkField]] = $rs;
            }
        }

        return $data;
    }

    public function getTypeIds()
    {
        $data = array();
        $modules = $this->getAll(array('id_configure_module' => true, 'fk_module_type' => true, 'fk_configure_module' => true));
        foreach ($modules as $module) {
            $data[$module['id_configure_module']] = $module;
        }

        return $data;
    }

    public function getSchema($tableName, $dataFields)
    {
        if (empty($dataFields)) {
            $dataFields = array();
        }

        $data = array('name' => $tableName);
        $tbl = new DbTable\Table($tableName);
        $data['orderFields'] = array(
            $tbl->getShortTableName() . '.order_id DESC',
            $tbl->getShortTableName() . '.order_id ASC',
            $tbl->getShortTableName() . '.addtime ASC',
            $tbl->getShortTableName() . '.addtime DESC',
        );

        $result = $tbl->getSchema();
        while ($rs = $result->fetch()) {
            $data['orderFields'][] = $tbl->getShortTableName() . '.' . $rs['Field'] . ' ASC';
            $data['orderFields'][] = $tbl->getShortTableName() . '.' . $rs['Field'] . ' DESC';

            $row = array('Field' => $rs['Field'], 'FieldType' => $rs['Type'], 'hidden' => true);
            if (array_key_exists($rs['Field'], $dataFields)) {
                if (!empty($dataFields[$rs['Field']]['setting']['static_options'])) {
                    $dataFields[$rs['Field']]['setting']['static_options'] = array_values($dataFields[$rs['Field']]['setting']['static_options']);
                    $dataFields[$rs['Field']]['setting']['count_options'] = count(array_values($dataFields[$rs['Field']]['setting']['static_options']));
                }
                $row = $row + $dataFields[$rs['Field']];
            }
            $data['fields'][$rs['Field']] = $row;
        }
        return $data;
    }

    public function addField($tableName, $fieldData)
    {
        $tbl = new DbTable\Table($tableName);
        $tbl->addField($fieldData['name'], $fieldData['type'], $fieldData['length'], $fieldData['default']);
    }

    public function createCustomizeTable($tableName, $pkField, $parentField)
    {
        $tbl = new DbTable\Table($tableName);
        $tbl->createCustomizeTable($pkField, $parentField);
    }

    public function createCustomizeLinkCategoryTable($tableName, $fkField, $fkCatField)
    {
        $tbl = new DbTable\Table($tableName . '_link_category');
        $tbl->createCustomizeLinkCategoryTable($fkField, $fkCatField);
    }

    public function createCustomizeLinkMediaTable($tableName, $fkField)
    {
        $tbl = new DbTable\Table($tableName . '_link_media');
        $tbl->createCustomizeLinkMediaTable($fkField);
    }

    public function getById($moduleId)
    {
        $data = $this->table->getByPkId($moduleId);
        if (empty($data)) {
            return null;
        }
        return $this->getDecodeData($data);

    }

    public function getByModuleTypeIdAndTypeId($moduleTypeId, $typeId)
    {
        $data = $this->table->findOneByCriteria(array('module_type_id' => $moduleTypeId, 'type_id' => $typeId));
        return $this->getDecodeData($data);
    }

    protected function getModuleTypes()
    {
        $moduleTypeIds = array();
        foreach (ModuleType::getInstance()->getAll() as $row) {
            $moduleTypeIds[$row['module_type']] = $row['id_configure_module_type'];
        }

        return $moduleTypeIds;
    }


    protected function getDecodeData($data)
    {

        if ($data['core_data']) {
            $data['core_data'] = unserialize($data['core_data']);
        }

        if ($data['cfg_data']) {
            $data['cfg_data'] = unserialize($data['cfg_data']);
        }

        $moduleTypeIds = array_flip($this->getModuleTypes());
        $data['module_type'] = $moduleTypeIds[$data['fk_module_type']];
        return $data;
    }

    protected function generateTableFields($tableName, $hasLnTable = false, $catTableName = null)
    {
        $table = array(
            'tbl' => array(
                'name' => $tableName,
                'pk_field' => 'id_' . $tableName,
                'parent_field' => 'parent_fk_' . $tableName,
            )
        );

        if ($catTableName) {
            $table['tbl']['parent_field'] = 'fk_' . $catTableName;
        }

        if ($hasLnTable) {
            $table['ln_tbl'] = array(
                'name' => $tableName . '_ln',
                'pk_field' => 'fk_' . $tableName,
            );
        }

        return $table;
    }

    public function create($data)
    {
        $cfg = array(
            'entity' => array(
                'content' => $this->generateTableFields('content', true, 'category'),
                'category' => $this->generateTableFields('category', true),
            ),
            'html' => array(
                'content' => $this->generateTableFields('html', true),
            ),
        );

        $moduleType = $data['core_data']['module_type'];
        //$data['core_data'] = null;
        if ($moduleType == 'html' || $moduleType == 'entity') {
            $data['core_data'] = $cfg[$moduleType];
        } elseif ($moduleType == 'customize') {
            $catTbl = null;
            if (!empty($data['core_data']['content']['has_category'])) {
                $catTbl = $data['core_data']['content']['tbl'] . '_category';
            }

            $coreData = array(
                'content' => $this->generateTableFields($data['core_data']['content']['tbl'], false, $catTbl)
            );

            $this->createCustomizeTable(
                $coreData['content']['tbl']['name'],
                $coreData['content']['tbl']['pk_field'],
                $coreData['content']['tbl']['parent_field']
            );

            $this->createCustomizeLinkMediaTable(
                $coreData['content']['tbl']['name'],
                'fk_' . $coreData['content']['tbl']['name']
            );

            if ($catTbl) {
                $coreData['category'] = $this->generateTableFields($catTbl);
                $this->createCustomizeTable(
                    $coreData['category']['tbl']['name'],
                    $coreData['category']['tbl']['pk_field'],
                    $coreData['category']['tbl']['parent_field']
                );

                $this->createCustomizeLinkCategoryTable(
                    $coreData['content']['tbl']['name'],
                    'fk_' . $coreData['content']['tbl']['name'],
                    'fk_' . $coreData['category']['tbl']['name']
                );
            }

            $data['core_data'] = $coreData;

        }

        $moduleTypeIds = $this->getModuleTypes();
        /*
        $typeId = $this->getTable()->getMaxTypeId($moduleTypeIds[$moduleType]) + 1;
        if ($moduleType == 'html') {
            $table = new DbTable\Entity\Html();
            $table->insert(array('id_html' => $typeId), true);
        }*/



        $insertedId =  $this->getTable()->insert(array(
            'fk_module_type' => $moduleTypeIds[$moduleType],
            //'type_id__exact' => $typeId,
            'core_data' => serialize($data['core_data']),
            'url' => $data['url'],
            'name' => $data['name'],
            //'description' => $data['description'],
        ));
        \Puja\Bob\DbTable\Configure\PageMeta::getInstance()->insert(array(
            'name' => $data['name'],
            'fk_configure_module' => $insertedId,
        ));

        return $insertedId;
    }

    public function update($data, $pkId = 0)
    {
        if (!empty($data['cfg_data'])) {
            $data['cfg_data'] = serialize($data['cfg_data']);
        }

        \Puja\Bob\DbTable\Configure\PageMeta::getInstance()->updateByCriteria(array(
            'name' => $data['name'],
        ), array('fk_configure_module' => $pkId));
        
        return parent::update($data, $pkId);
    }
}