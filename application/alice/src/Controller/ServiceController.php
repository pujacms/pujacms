<?php
namespace Puja\Alice\Controller;
use Puja\Alice\Middleware\Controller;
use Puja\Configure\Configure;

class ServiceController extends Controller
{
    protected $token;
    protected function init()
    {
        $token = Configure::getInstance('bobwebservice')->get('token', null);
        if (empty($token)) {
            throw new \Exception("Token is invalid");
        }

        $this->token = $token;
    }

    public function updateI18nAction()
    {
        $service = \Puja\Library\Service\Token::getInstance($this->token);
        var_dump($service->validToken('adfasdfasdfasfasf'));
        echo 'hehehee';
    }
}