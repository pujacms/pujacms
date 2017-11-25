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

    public function getHtmlParentTreeByPkId($pkId)
    {

        $html = '';
        if (empty($pkId)) {
            return $html;
        }

        $parentCategories = $this->getParentsByPkId($pkId);
        if (empty($parentCategories)) {
            return $html;
        }

        $parentIds = array();
        foreach ($parentCategories as $category) {
            $parentIds[] = $category[$this->table->getParentField()];
        }

        $categories = $this->table->findByCriteria(array(
            $this->table->getParentField() . '__in' => implode(',', $parentIds)
        ));

        $tree = array(array(
            "pkid" => 0,
            'text' => 'Root',
            'children' => array(),
        ));
        $mapParentCategories = array();
        foreach ($categories as $category) {
            $category['text'] = $category['name'];
            $category['pkid'] = $category[$this->table->getPkField()];
            $parentId = $category[$this->table->getParentField()];
            $mapParentCategories[$parentId][] = $category;
        }

        $tree[0]['children'] = $mapParentCategories[0];
        return $tree;
        foreach ($parentCategories as $parentCategory) {
            $parentId = $parentCategory[$this->table->getParentField()];
            $catId = $parentCategory[$this->table->getPkField()];;
            $html = $this->generateHtml($html, $mapParentCategories[$parentId], $catId);
        }

        return str_replace($this->generatePlaceHolder, '', $html);
    }

    protected function generateHtml($htmlResult, $categories, $catId)
    {
        $html = '<ul>';
        foreach ($categories as $category) {
            $pkId = $category[$this->table->getPkField()];;
            $html .= '<li>' . $category['name'] . ($catId == $pkId ? $this->generatePlaceHolder : '') .  '</li>';
        }
        $html .= '</ul>';

        if (empty($htmlResult)) {
            $htmlResult = $html;
        } else {
            $htmlResult = str_replace($this->generatePlaceHolder, $html, $htmlResult);
        }

        return $htmlResult;
    }
}