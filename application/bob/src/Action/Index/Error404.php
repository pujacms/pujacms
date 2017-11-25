<?php
namespace Puja\Bob\Action\Index;
use Puja\Middleware\Action;

class Error404 extends Action
{
    public function run() {
        header('HTTP/1.1 404 Page Not Found');
        header('Status: 404 Page Not Found');
        header('Cache-Control: no-cache, must-revalidate');
        $this->controller->render('404.tpl', array());
    }
}