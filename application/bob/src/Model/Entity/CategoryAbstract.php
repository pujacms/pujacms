<?php
namespace Puja\Bob\Model\Entity;
use Puja\Bob\DbTable;
abstract class CategoryAbstract extends EntityAbstract
{
    protected $generatePlaceHolder = '[{PUJA_CATEGORY_PLACEHODLER_GENERATOR}]';
    public function getParentsByPkId($pkId)
    {
        $parents = array();
        while ($pkId) {
            $category = $this->table->findOneByCriteria(array(
                $this->table->getPkField() => $pkId
            ));

            if (empty($category)) {
                break;
            }

            $category['pkid'] = $category[$this->table->getPkField()];
            $parents[$category['pkid']] = $category;
            $pkId = $category[$this->table->getParentField()];
        }

        asort($parents);
        return $parents;
    }

    public function getChildByPkId($pkId)
    {
        $result = array();
        $categories = $this->table->findByCriteria(array(
            $this->table->getParentField()  => $pkId
        ), 'order_id');
        foreach ($categories as $category) {
            $result[] = array(
                'id' => $category[$this->table->getPkField()],
                'text' => $category['name'],
                'state' => 'closed',
            );
        }

        return $result;
    }

    public function getTreeByPkId($pkId)
    {
        $tree = array(
            'id' => 0,
            'text' => 'Root',
            'children' => array(),
        );

        if (empty($pkId)) {
            $tree['current'] = true;
            $tree['children'] = $this->getChildByPkId($pkId);
            return array($tree);
        }

        $parentCategories = $this->getParentsByPkId($pkId);
        if (empty($parentCategories)) {
            return array($tree);
        }

        $parentIds = array();
        foreach ($parentCategories as $category) {
            $parentIds[] = $category[$this->table->getParentField()];
        }

        $categories = $this->table->findByCriteria(array(
            $this->table->getParentField() . '__in' => implode(',', $parentIds)
        ));



        $mapParentCategories = array();
        foreach ($categories as $category) {
            $node = array(
                'id' => $category[$this->table->getPkField()],
                'parent_id' => $category[$this->table->getParentField()],
                'text' => $category['name'],
            );

            if ($node['id'] == $pkId) {
                $node['current'] = true;
            }
            $mapParentCategories[$node['parent_id']][] = $node;
        }



        $tree = $this->buildTree($tree, $mapParentCategories, 0);

        return array($tree);
        
    }

    protected function buildTree(&$tree, $mapping, $key)
    {
        $next = false;
        $nextIndex = null;
        $categories = $mapping[$key];

        foreach ($categories as $index => $category) {
            $category['state'] = 'closed';

            if (!empty($mapping[$category['id']])) {
                $category['state'] = 'open';
                $key = $category['id'];
                $nextIndex = $index;
                $next = true;
            }

            $tree['children'][$index] = $category;
        }

        if ($next) {
            $this->buildTree($tree['children'][$nextIndex], $mapping, $key);
        }
        return $tree;
    }

    protected function buildChild($tree, $parentId, $categories)
    {
        foreach ($categories as $key => $category) {
            $tree[$key] = $category;
        }

        return $tree;
    }
}