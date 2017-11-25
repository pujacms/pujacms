<?php
defined('APPLICATION_DIR') || define('APPLICATION_DIR', realpath($configurePaths[0] . '/../') . '/');
defined('APPLICATION_ROOT') || define('APPLICATION_ROOT', realpath(APPLICATION_DIR . '/../') . '/');
defined('DEBUG_MODE') || define('DEBUG_MODE', true);

$configures = array();
/** This configures can access from template files */
$configures['application'] = array(
    'path_dir' => '%application.path_dir%',
    'static_server' => '%application.static_server%',
    'upload_server' => '%application.upload_server%',
);
/** End */


/** PLEASE DO NOT TOUCH IF YOU ARE NOT SURE */
$configures['cache_dir'] = APPLICATION_ROOT . '/../data/cache/alice/';
$configures['upload_dir'] = APPLICATION_ROOT . '/../data/upload/';

$configures['router'] = array(
    'root_namespace' => '\\Puja\\Alice\\',
    'default_controller' => 'Index',
    'default_action' => 'index',
    'exclude_action' => array('beforeLoad', 'afterLoad'),
    'controller_dir' => APPLICATION_DIR . '/src/Controller/',
    'module_dir' => APPLICATION_DIR . '/src/Module/',
    'cache_dir' => APPLICATION_ROOT . '/../data/cache/alice/',
);

$configures['TemplateEngine'] = array(
    'templateDirs' => array(APPLICATION_DIR . 'templates/Default'),
    'cacheDir' => APPLICATION_ROOT . '/../data/cache/alice/',
    'cacheLevel' => DEBUG_MODE ? 0 : 1,
    'customTag' => '\\Puja\\Library\\TemplateEngine\\CustomTag',
    'customFilter' => '\\Puja\\Library\\TemplateEngine\\CustomFilter',
    'debug' => DEBUG_MODE,
);

$configures['error_handler'] = array(
    'enabled' => true,
    'debug' => DEBUG_MODE,
    'error_display' => true,
    'error_level' => E_ALL,
    'error_template' => APPLICATION_DIR . '/templates/Default/500.tpl',
);

$configures['application'] = array_merge($configures['application'], array(
    'request_uri' => 'REQUEST_URI',
    'Bootstrap' => '\\Puja\\Middleware\\Bootstrap',
    'View' => '\\Puja\\Middleware\\View',
    'Route' => '\\Puja\\Middleware\\Route',
    'error404' => array('controller' => '\\Puja\\Alice\\Controller\\IndexController', 'action' => '\\Puja\\Alice\\Action\\Index\\Error404', 'annotation' => true),
));

