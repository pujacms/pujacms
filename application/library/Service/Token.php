<?php
namespace Puja\Library\Service;
class Token
{
    private static $instance;
    private $tokenCfg;
    private function __construct($tokenCfg)
    {
        if (empty($tokenCfg)) {
            throw new \Exception('Token configure must NOT empty!');
        }

        $this->tokenCfg = $tokenCfg;
    }

    /**
     * @param $tokenCfg
     * @return static
     */
    public static function getInstance($tokenCfg)
    {
        if (null === static::$instance) {
            static::$instance = new static($tokenCfg);
        }

        return static::$instance;
    }

    public function generateToken()
    {
        return sha1(md5($this->tokenCfg . time()));

    }

    public function validToken($token)
    {
        return $token == sha1(md5($this->tokenCfg . time()));
    }

}