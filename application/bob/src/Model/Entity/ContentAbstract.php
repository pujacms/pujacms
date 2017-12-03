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
}