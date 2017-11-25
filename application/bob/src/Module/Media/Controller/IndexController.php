<?php
namespace Puja\Bob\Module\Media\Controller;
use Puja\Bob\Module\Media\Model\DataGrid;

class IndexController extends \Puja\Bob\Controller\DataGrid\DataGridAbstract
{
    /**
     * @var \Puja\Bob\Model\Media\Media
     */
    protected $model;
    protected function getModel()
    {
        return \Puja\Bob\Model\Media\Media::getInstance();
    }

    protected function getDataGridModel()
    {
        return DataGrid\Media::getInstance($this);
    }

    public function uploadAction()
    {
        $uploadData = $this->model->upload(
            $this->getParam('typeid', null),
            $this->getParam('recordType', null),
            $this->getParam('params')
        );
        return $this->json(array(
            'status' => true,
            'media_id' => $uploadData['media_id'],
            'src' => $uploadData['src'],
        ));
    }

    public function uploadNormalAction()
    {
        $uploadData = $this->model->uploadNormal();
        return $this->json(array(
            'status' => true,
            'media_id' => $uploadData['media_id'],
            'location' => \Puja\Configure\Configure::getInstance('application')->get('upload_server') . '/' . $uploadData['src'],
        ));
    }

    public function treeAction()
    {
        die('Filter Tree');
    }
}