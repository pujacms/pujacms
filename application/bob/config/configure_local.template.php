<?php
$configures['database'] = array(
    'write_adapter_name' => 'master',
    'table_prefix' => 'puja_',
    'adapters' => array(
        'master' => array(
            'host' => '<dbhost>',
            'username' => '<dbusername>',
            'password' => '<dbpassword>',
            'dbname' => '<dbname>',
            'charset' => 'utf8',
        )
    )
);

$configures['application']['company_name'] = 'PujaCMS';
$configures['application']['root_admin'] = true;