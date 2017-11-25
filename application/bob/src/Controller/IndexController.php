<?php
namespace Puja\Bob\Controller;
use Puja\Bob\Middleware\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->render('Index/index.tpl', array());
    }
}