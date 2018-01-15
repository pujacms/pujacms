<?php
namespace Puja\Bob\Model\Entity;
use Puja\Bob\DbTable;
abstract class ContentAbstract extends EntityAbstract
{
    public function getCategoryIdByPkId($pkId)
    {
        $content = $this->table->getByPkId($pkId);
        return $content[$this->table->getParentField()];
    }

    public function updateCategoryIdByPkId($catId, $pkId, $parents = array())
    {
        $linkContentCategory = Processor\LinkContentCategory::getInstance($this->table, $this->cfgModule, static::$recordType);
        $linkContentCategory->save($pkId, $catId, $parents);
        $this->updateByPkId(array($this->table->getParentField() => (int) $catId), $pkId);
    }

    /**
     * @param array $options Array( [field] => related_ids [type] => datagrid_list [contentid] => 12 )
     */
    public function getDynamicData($options)
    {
        $result = array('total' => 0, 'list' => array());
        if (empty($options['field'])) {
            return $result;
        }
        
        $linkContentContent = Processor\LinkContentContent::getInstance($this->table, $this->cfgModule, static::$recordType);
        return $linkContentContent->getDynamicData($options);
    }




}