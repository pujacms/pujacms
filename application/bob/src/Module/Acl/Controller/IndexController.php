<?php
namespace Puja\Bob\Module\Acl\Controller;
use Puja\Bob\Middleware\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
        $data = array();
        $routes = \Puja\Route\Route::getRoutes();
        print_r($routes);exit;

        $this->render('EasyUi/DataGrid.tpl', $data);
    }
}