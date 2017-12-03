<?php
namespace Puja\Bob\DbTable\Category;

class Category extends \Puja\Bob\DbTable\Entity\EntityMultiLnAbstract
{
    protected $tableName = 'category';
    protected $pkField = 'id_category';
    protected $parentField = 'parent_fk_category';
    public function getParentIdByCategoryId($categoryId)
    {
        $data = $this->getByPkId($categoryId);
        if (empty($data)) {
            return 0;
        }

        return $data[$this->parentField];
    }
}