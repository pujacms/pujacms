<?php
namespace Puja\Bob\Model;
class Auth
{
    public function login($userName, $password)
    {
        $userModel = new \Puja\Bob\Model\User();
        $user = $userModel->getByUserNameAndPassword($userName, $password);
        if (empty($user)) {
            return false;
        }
        $userModel->setCurrentUser($user);

        return true;

    }

    public function logout()
    {
        $userModel = new \Puja\Bob\Model\User();
        $userModel->destroy();
    }
}