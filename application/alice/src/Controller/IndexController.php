<?php
namespace Puja\Alice\Controller;
use Puja\Alice\Middleware\Controller;
class IndexController extends Controller
{
    public function indexAction()
    {
        $this->render('Index/index.tpl', array());
    }
}