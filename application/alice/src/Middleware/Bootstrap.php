<?php
namespace Puja\Alice\Middleware;

class Bootstrap extends \Puja\Middleware\Bootstrap
{
    protected function init()
    {
        new \Puja\Session\Session(
            \Puja\Configure\Configure::getInstance('session')->getAll()
        );
    }
}