<?php
namespace Puja\Alice\Model\Bob;
class Adapter
{
    protected static $instance;
    /**
     * @return static
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct()
    {
    }

    public function set($handler, $data = array())
    {
        $this->processHandler($handler, $data, 'set');
    }


    public function get($handler, $data = array())
    {
        $this->processHandler($handler, $data, 'get');
    }

    protected function processHandler($handler, $data = array(), $method = 'get')
    {
        $clsName = '\\Puja\\Alice\\Model\\Bob\\Handler\\' . $handler;
        if (!class_exists($clsName)) {
            throw new \Exception('Class: ' . $clsName . ' doesnt exist!');
        }

        $handler = new $clsName(\Puja\Configure\Configure::getInstance('bobwebservice'));
        if (!($handler instanceof \Puja\Alice\Model\Bob\Handler\HandlerAbstract)) {
            throw new \Exception('Class: ' . $clsName . ' must be instance of \\Puja\\Alice\\Model\\Bob\\Handler\\HandlerAbstract');
        }

        if ($method == 'set') {
            $result = $handler->set($data);
        } else {
            $result = $handler->get($data);
        }

        return $result;
    }

    protected function getHandlerInstance()
    {

    }
}