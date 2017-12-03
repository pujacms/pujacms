<?php
namespace Puja\Bob\Controller\DataGrid\Entity;

abstract class ContentAbstract extends DataGridAbstract
{
    /**
     * @var \Puja\Bob\Model\Content\Content
     */
    protected $model;
    public function moveAction()
    {
        if ($this->getParam('id')) {
            // id = category id, the parameter from tree
            $tree = $this->getCategoryModel()->getChildByPkId($this->getParam('id', 0));
        } else {
            // pkid: content id
            $catId = $this->model->getCategoryIdByPkId($this->getParam('pkid', 0));
            $tree = $this->getCategoryModel()->getTreeByPkId($catId);
        }
        $this->json($tree);
    }

    public function updateCategoryAction()
    {
        if ($_POST) {
            $catId = (int) $this->getParam('catid');
            $this->model->updateCategoryIdByPkId(
                $catId,
                $this->getParam('pkid'),
                $this->getCategoryModel()->getParentsByPkId($catId)
            );
            return $this->json(array('status' => true));
        }

        return $this->json(array('status' => false, 'message' => 'INVALID_REQUEST_METHOD'));
    }

    public function dynamicOptionDataAction()
    {
        $list = $list = $this->model->getList();

        return $this->json($list);
    }
}