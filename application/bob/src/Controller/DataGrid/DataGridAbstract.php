<?php
namespace Puja\Bob\Controller\DataGrid;

abstract class DataGridAbstract extends \Puja\Bob\Middleware\Controller
{
    /**
     * @var \Puja\Bob\Model\AbstractLayer\ModelAbstract
     */
    protected $model;
    /**
     * @var \Puja\Bob\Model\DataGrid\ConfigureAbstract
     */
    protected $dataGridModel;

    abstract protected function getModel();

    abstract protected function getDataGridModel();

    public function beforeLoadAction()
    {
        parent::beforeLoadAction();
        $this->dataGridModel = $this->getDataGridModel();
        $this->model = $this->getModel();

    }

    public function indexAction()
    {
        $this->addJsonStore(array(
            'pkField' => $this->dataGridModel->getPkField(),
            'moduldeId' => $this->getModuleId(),
            'controllerId' => $this->getControllerId(),
            'DataGrid' => array(
                'actions' => $this->dataGridModel->getActions(),
            )
        ));
        $this->view->parse('EasyUi/DataGrid.tpl', $this->getIndexActionData());

    }

    protected function getIndexActionData()
    {
        $viewData = array(
            'datagrid' => $this->dataGridModel->getSimple(),
            'JsHandler' => $this->dataGridModel->getJsHandler(),
        );
        $viewData['JsHandlerFile'] = str_replace('.', '/', $viewData['JsHandler']);
        return $viewData;
    }

    public function listAction()
    {
        $this->json(
            $this->model->getList(
                $this->getParam('parentid'),
                $this->getParam('query', null),
                $this->getParam('sort', $this->listSortDefault()) . ' ' . $this->getParam('order', 'asc'),
                max(0, $this->getParam('page') - 1),
                $this->getParam('rows', 10)
            )
        );
    }

    protected function listSortDefault()
    {
        return $this->dataGridModel->getPkField();
    }

    public function updateAction()
    {
        if ($_POST) {
            $this->processUpdate();
        }

        $this->renderUpdate();
    }

    protected function processUpdate()
    {
        $this->model->update($this->getParam('entity'), $this->getParam('pkid', 0));
        $this->json(array('status' => true));
    }

    public function renderUpdate()
    {

    }
    
    public function deleteAction()
    {
        $this->processDelete();
    }

    protected function processDelete()
    {
        $this->model->deleteByPkId($this->getParam('pkid'));
    }

    public function toggleStatusAction()
    {
        $this->model->toggleStatusByPkId($this->getParam('pkid'));
    }

}