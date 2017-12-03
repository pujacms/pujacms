<?php
namespace Puja\Bob\Controller\DataGrid\Entity;

use Puja\Bob\Model\Constant;

abstract class BkDataGridMultiLnAbstract extends \Puja\Bob\Controller\DataGrid\Entity\DataGridAbstract
{
    /**
     * @var \Puja\Bob\Model\Entity\EntityLocalizeAbstract
     */
    protected $localizeModel;
    abstract protected function getLocalizeModel();


    public function beforeLoadAction()
    {
        parent::beforeLoadAction();
        $this->localizeModel = $this->getLocalizeModel();
    }

    protected function setUpdateData($pkId, $parentId)
    {
        $entityId =  parent::setUpdateData($pkId, $parentId);
        $this->localizeModel->setEntityLocalize(
            $entityId,
            $this->getParam(Constant::LN_ENTITY)
        );
        return $entityId;

    }

    protected function getUpdateData($pkId, $parentId)
    {
        $data = parent::getUpdateData($pkId, $parentId);
        $data['IsMultiLang'] = true;
        $data['LnEntities'] = $this->localizeModel->getEntityByPkId($pkId);
        return $data;
    }
}