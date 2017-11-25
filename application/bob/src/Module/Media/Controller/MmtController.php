<?php
namespace Puja\Bob\Module\Media\Controller;
use Puja\Bob\Middleware\Controller;
use Puja\Bob\Module\Media\Model\Media;

class MmtController extends Controller
{
    protected $cfgModule;
    protected $moduleType;
    protected $typeId;

    public function beforeLoadAction()
    {
        parent::beforeLoadAction();

    }

    public function indexAction()
    {
        $model = new Media();

        echo json_encode(array('rows' => $model->getList(), 'total' => $model->getTotal()));

    }

    public function uploadAction()
    {
        die('upload');
    }

    public function treeAction()
    {
        die('Filter Tree');
    }
}