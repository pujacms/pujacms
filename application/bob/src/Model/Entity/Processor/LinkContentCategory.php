<?php
namespace Puja\Bob\Model\Entity\Processor;
use Puja\Bob\DbTable;

class LinkContentCategory extends ProcessorAbstract
{
    /**
     * @var DbTable\Entity\LinkAbstract
     */
    protected $table;
    public function save($contentId, $categoryId, $parents = null)
    {

        if ('content' != $this->recordType) {
            return null;
        }

        if (empty($categoryId)) {
            return null;
        }

        $catFieldName = 'id_' . substr($this->table->getParentField(), 3);
        if (empty($parents)) {
            $parents[] = array($catFieldName => $categoryId);
        }

        $linkTable = $this->getLinkTable();
        if (null === $linkTable) {
            return null;
        }


        $linkTable->deleteByPkId($contentId);
        foreach ($parents as $parent) {
            $linkTable->insert(array(
                $linkTable->getPkField() => $contentId,
                $linkTable->getParentField() => $parent[$catFieldName],
            ));
        }
    }

    public function updateParentIdByPkId($pkId, $parentId, $parents = null)
    {

    }

    protected function getLinkTable()
    {
        if ($this->cfgModule['module_type'] != 'entity' && $this->cfgModule['module_type'] != 'customize') {
            return null;
        }

        if ($this->cfgModule['module_type'] == 'entity') {
            return DbTable\Link\ContentCategory::getInstance();
        }

        if ($this->cfgModule['module_type'] == 'customize' && !empty($this->cfgModule['core_data']['category']['tbl'])) {
            $table = DbTable\Link\ContentCategory::getInstance($this->cfgModule['core_data']['content']['tbl']['name'] . '_link_category');
            $table->setPkField('fk_' . $this->cfgModule['core_data']['content']['tbl']['name']);
            $table->setParentField('fk_' . $this->cfgModule['core_data']['category']['tbl']['name']);

            return $table;
        }

        return null;
    }

}