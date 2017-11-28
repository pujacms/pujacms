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

    public function updateCategoryIdByPkId($catId, $pkId)
    {
        
        $this->updateByPkId(array($this->table->getParentField() => (int) $catId), $pkId);
    }
}