<?php
$configures['database'] = array(
    'write_adapter_name' => 'master',
    'table_prefix' => 'puja_',
    'adapters' => array(
        'master' => array(
            'host' => 'localhost',
            'username' => 'root',
            'password' => '123',
            'dbname' => 'pujacms',
            'charset' => 'utf8',
        )
    )
);

$configures['application']['company_name'] = 'PujaCMS';
$configures['application']['root_admin'] = true;