<?php
namespace Puja\Bob\Module\Html\Controller;
use Puja\Bob\Module\Entity\Model\Partial;

class ContentController extends \Puja\Bob\Controller\DataGrid\Entity\DataGridAbstract
{
    /**
     * @var \Puja\Bob\Model\Html\Html
     */
    protected $model;
    protected function getDataGridModel()
    {
        return \Puja\Bob\Module\Entity\Model\DataGrid\Configure\Content::getInstance($this);
    }

    protected function getModel()
    {
        return \Puja\Bob\Model\Html\Html::getInstance(
            $this->idConfigureModule,
            $this->getCurrentCfgModule(),
            $this->configureLanguageId
        );
    }

    public function indexAction()
    {
        $this->redirect('./');
    }

    protected function getCategoryModel()
    {
        return \Puja\Bob\Model\Html\Html::getInstance(
            $this->idConfigureModule,
            $this->getCurrentCfgModule(),
            $this->configureLanguageId
        );
    }

    /*
    protected function getLocalizeModel()
    {
        return \Puja\Bob\Model\Html\HtmlLocalize::getInstance(
            $this->idConfigureModule,
            $this->getCurrentCfgModule()
        );
    }*/

    protected function getUpdateData($pkId, $parentId, $level)
    {
        $detail = $this->model->getByPkId($pkId);
        if (empty($detail)) {
            $this->model->addRecordByPkId($pkId);
        }
        $data = parent::getUpdateData($pkId, $parentId, $level);
        $data['BackUrl'] = './';
        return $data;
    }
}