<?php
namespace Puja\Bob\Module\System\Controller;
use Puja\Bob\Module\System\Model\DataGrid;

class ConfigureGroupController extends \Puja\Bob\Controller\DataGrid\DataGridAbstract
{
    protected function getModel()
    {
        return \Puja\Bob\Model\Configure\ConfigureGroup::getInstance();
    }

    protected function getDataGridModel()
    {
        return DataGrid\ConfigureGroup::getInstance($this);
    }

    public function updateAction()
    {
        if ($_POST) {
            return parent::updateAction(); // TODO: Change the autogenerated stub
        }
        $data = array();
        if ($this->getParam('pkid')) {
            $data['entity'] = $this->getModel()->getByPkId($this->getParam('pkid'));
        }
        $this->render('System/Update/ConfigureGroup.tpl', $data);
    }

}