<?php
namespace Puja\Bob\Module\User\Controller;

use Puja\Bob\Model\User;

class IndexController extends \Puja\Bob\Middleware\Controller
{
    public function indexAction()
    {
        $this->view->parse('User/Profile.tpl');
    }

    public function resetPasswordAction()
    {

        if ($_POST) {
            $model = \Puja\Bob\Model\User::getInstance();
            $user = $model->getCurrentUser();
            $checkCurrentPassword = \Puja\Bob\Model\User::getGeneratedPassword($this->getParam('current_password')) !== $user['password'];
            if ($checkCurrentPassword) {
                $this->json(array(
                    'status' => false,
                    'msg' => 'Current password is not correct'
                ));
            }

            $model->updatePasswordByPkId($user['id_acl_user'], $this->getParam('password'));
            $model->destroy();
            $this->json(array(
                'status' => true,
                'msg' => null
            ));

        }
        $this->view->parse('User/ResetPassword.tpl');
    }
}