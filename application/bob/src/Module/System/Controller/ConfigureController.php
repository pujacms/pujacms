<?php
namespace Puja\Bob\Module\System\Controller;
use Puja\Bob\Module\System\Model\DataGrid;
use Puja\Bob\Model\Configure;

class ConfigureController extends \Puja\Bob\Controller\DataGrid\DataGridAbstract
{
    public function indexAction()
    {
        $cfgGroupModel = Configure\ConfigureGroup::getInstance();
        $cfgGroups = $cfgGroupModel->getAll();
        $this->addJsonStore(array(
            'categories' => $cfgGroups,
        ));
        parent::indexAction();

    }

    public function updateAction()
    {
        if ($_POST) {
            $this->getModel()->update($this->getParam('entity'), $this->getParam('pkid'));
            $this->redirect('./?module=' . $this->getModuleId() . '&ctrl=' . $this->getControllerId());
            return;
        }
        $cfgGroupModel = Configure\ConfigureGroup::getInstance();
        $field = array();
        if ($this->getParam('pkid')) {
            $field = $this->getModel()->getByPkId($this->getParam('pkid'));
        }
        $field['Field'] = 'configure';
        $data = array(
            'CfgFieldType' => \Puja\Configure\Configure::getInstance('FieldTypes')->getAll(),
            'ConfigureGroup' => $cfgGroupModel->getAll(),
            'InputFieldName' => 'entity',
            'field' => $field
        );
        $this->render('System/Update/Configure.tpl', $data);
    }

    /**
     * @return Configure\Configure
     */
    protected function getModel()
    {
        return Configure\Configure::getInstance();
    }

    protected function getDataGridModel()
    {
        return DataGrid\Configure::getInstance($this);
    }

}