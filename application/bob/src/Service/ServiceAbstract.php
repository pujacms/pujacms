<?php
namespace Puja\Bob\Service;
class ServiceAbstract
{

    protected function __construct()
    {
    }

    public static function getInstance()
    {
        return new static();
    }
}