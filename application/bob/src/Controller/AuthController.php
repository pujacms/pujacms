<?php
namespace Puja\Bob\Controller;

class AuthController extends \Puja\Bob\Middleware\Controller
{
    public function indexAction()
    {
        $this->render('auth/login.tpl', array());
    }

    public function loginAction()
    {
        $authModel = new \Puja\Bob\Model\Auth();
        $result = $authModel->login(
            $this->getParam('username'),
            $this->getParam('password')
        );
        
        $this->json(array('status' => $result, 'msg' => $result ? null : 'Your username/password is wrong'));
    }

    public function logoutAction()
    {
        //$this->user->destroy();
        $authModel = new \Puja\Bob\Model\Auth();
        $authModel->logout();
        $this->redirect('./');
    }
}