<?php
namespace Puja\Alice\Module\News\Controller;
use Puja\Middleware\Controller;
class IndexController extends Controller
{
    public function indexAction()
    {
        $this->render('News/Index/index.tpl');
    }

    public function detailAction()
    {
        $this->render('News/Index/detail.tpl');
    }

}