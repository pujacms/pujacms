<?php
namespace Puja\Alice\Model\Bob;
interface AdapterInterface
{
    public function get($handler, $data = array());
    public function set($handler, $data = array());
}