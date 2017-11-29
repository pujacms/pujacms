<?php
namespace Puja\Bob\Module\Configure\Controller;
use Puja\Bob\Model\Configure;
use Puja\Bob\Module\Configure\Model\DataGrid;


class WebtranslateController extends \Puja\Bob\Controller\DataGrid\DataGridAbstract
{
    /**
     * @var Configure\Webtranslate
     */
    protected $model;
    protected function getModel()
    {
        return Configure\Webtranslate::getInstance();
    }

    protected function getDataGridModel()
    {
        return DataGrid\Webtranslate::getInstance($this);
    }

    public function renderUpdate()
    {
        $data = $this->model->getEntityByPkId($this->getParam('pkid', 0));
        $this->view->parse('Configure/Webtranslate.html', $data);
    }

    protected function processUpdate()
    {
        $this->model->updateEntityByPkId(
            $this->getParam('pkid', 0),
            $this->getParam('MainEntity'),
            $this->getParam('LnEntity')
        );
        $this->json(array('status' => true));
    }

    public function importAliceAction()
    {
        $this->json(array(
            'status' => $this->model->importEntityToAlice(),
        ));
    }
}