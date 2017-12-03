<?php
namespace Puja\Bob\Module\Webservice\Controller;

class AliceController extends \Puja\Bob\Middleware\Controller
{
    public function indexAction()
    {
        if ($_POST) {
            print_r($_POST);exit;
        }
        return $this->serviceResponse(array());
    }


    protected function serviceResponse($data, $status = true)
    {
        $this->json(array('status' => $status, 'data' => $data));
    }
}