<?php
namespace Puja\Bob\Middleware;
use Puja\Configure\Configure;
use Puja\Db\Adapter;
use Puja\Session\Session;

class Bootstrap extends \Puja\Middleware\Bootstrap
{
    protected function init()
    {
        // start session
        $session = new Session(Configure::getInstance('Session')->getAll());
        $session->start();

        // start db
        new Adapter(Configure::getInstance('database')->getAll());
    }
}