<?php
namespace Puja\Bob\Model\Entity\Processor;
use Puja\Bob\DbTable;

class LinkContentContent extends ProcessorAbstract
{
    public function save($srcContentId, $targetContentIds)
    {
        $linkTable = $this->getLinkTable();
        if (null === $linkTable) {
            return null;
        }
        
        $linkTable->deleteByPkId($srcContentId);

        if (empty($srcContentId) || empty($targetContentIds)) {
            return false;
        }
        
        foreach ($targetContentIds as $targetContentId) {
            
        }
        
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