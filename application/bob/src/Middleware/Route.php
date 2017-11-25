<?php
namespace Puja\Bob\Middleware;
class Route extends \Puja\Middleware\Route
{
    protected function rewrite($uri)
    {
        $uris = array();
        $request = $_GET;
        if (!empty($request['module'])) {
            $uris[] = $request['module'];
        }

        if (!empty($request['ctrl'])) {
            $uris[] = $request['ctrl'];
        }

        if (!empty($request['act'])) {
            $uris[] = $request['act'];
        }

        if (empty($uris)) {
            return 'index';
        }

        return implode('/', $uris);
    }
}