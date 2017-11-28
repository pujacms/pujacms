<?php
namespace Puja\Bob\Model;
use Puja\Bob\DbTable;
class User extends AbstractLayer\ModelAbstract
{
    protected $session;
    protected $currentUser;

    public function __construct()
    {
        parent::__construct();
        $this->session = \Puja\Session\Session::getInstance('Acl');
        $this->currentUser = $this->session->get('user');
    }

    protected function getTable()
    {
        return new DbTable\Acl\User();
    }

    public function getByUserNameAndPassword($username, $password)
    {
        return $this->table->findOneByCriteria(array('username' => $username, 'password' => self::getGeneratedPassword($password)));
    }

    public function updatePasswordByPkId($pkId, $password)
    {
        return $this->table->updateByPkId(array('password' => self::getGeneratedPassword($password)), $pkId);
    }

    public function isGuest()
    {
        return $this->currentUser ? false : true;
    }

    public function setCurrentUser($userData = array())
    {
        $this->session->set('user', $userData);
        $this->currentUser = $this->session->get('user');
    }

    public function get($key, $defaultValue = null)
    {
        if (empty($this->currentUser)) {
            return $defaultValue;
        }
        
        return array_key_exists($key, $this->currentUser) ? $this->currentUser[$key] : $defaultValue;
    }

    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    public function destroy()
    {
        $this->session->destroy();
    }

    public static function getGeneratedPassword($password)
    {
        return md5($password);
    }
}