<?php
namespace Puja\Bob\Model\Entity\Processor;
use Puja\Bob\DbTable;

class LinkContentContent extends ProcessorAbstract
{
    public function save($srcContentId, $targetData)
    {
        $linkTable = $this->getLinkTable();
        if (null === $linkTable) {
            return null;
        }
        
        $linkTable->deleteByPkId($srcContentId);

        if (empty($srcContentId) || empty($targetData)) {
            return false;
        }
        
        foreach ($targetData as $field => $targetIds) {
            foreach ($targetIds as $targetId) {
                $linkTable->insert(array(
                    'field_name' => $field,
                    'fk_content' => $srcContentId,
                    'target_fk_content' => $targetId,
                ));
            }

        }
    }

    public function getDynamicData($options)
    {
        $result = array('total' => 0, 'list' => array());
        $currentIds = array();
        $contentId = (int) $options['contentid'];

        if ($contentId) {
            $content = $this->table->getByPkId($contentId);

            if (empty($content) || empty($content[$options['field']])) {
                return $result;
            }

            $currentIds = explode(',', $content[$options['field']]);
        }

        switch ($options['type']) {
            case 'datagrid_list':
                $result = $this->getDynamicList($currentIds);

                break;

            case 'datagrid_search':
                break;

            default:
                throw new \Exception('Not supported type: "' . $options['type'] . '"');
                break;

        }


        return $result;

    }

    protected function getDynamicList($targetIds)
    {

        $mapIds = array();
        foreach ($targetIds as $id) {
            $mapIds[$id] = true;
        }

        $targetResult = $this->table->findByCriteria(array('fk_configure_module' => $this->cfgModule['id_configure_module']));
        foreach ($targetResult as $key => $rs) {
            $rs['checked'] = false;
            $rs['pkid'] = $rs[$this->table->getPkField()];

            if (!empty($mapIds[$rs['pkid']])) {
                $rs['checked'] = true;
            }
            $targetResult[$key] = $rs;
        }

        return $targetResult;
    }


    protected function getLinkTable()
    {
        if ($this->cfgModule['module_type'] != 'entity' && $this->cfgModule['module_type'] != 'customize') {
            return null;
        }

        if ($this->cfgModule['module_type'] == 'entity') {
            return DbTable\Link\ContentContent::getInstance();
        }

        if ($this->cfgModule['module_type'] == 'customize') {
            $table = DbTable\Link\ContentContent::getInstance($this->cfgModule['core_data']['content']['tbl']['name'] . '_link_content');
            $table->setPkField('fk_' . $this->cfgModule['core_data']['content']['tbl']['name']);
            $table->setParentField('fk_' . $this->cfgModule['core_data']['category']['tbl']['name']);

            return $table;
        }

        return null;
    }
}