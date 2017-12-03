<?php
namespace Puja\Alice\Controller;
use Puja\Alice\Middleware\Controller;
class IndexController extends Controller
{
    public function indexAction()
    {
        $this->render('Index/index.tpl', array());
    }

    public static function actions()
    {
        return array(
            'SwitchLocale' => '\\Puja\\Alice\\Action\\Index\\SwitchLocale',
        );
    }
}