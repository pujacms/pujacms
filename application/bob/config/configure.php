<?php
defined('APPLICATION_DIR') || define('APPLICATION_DIR', realpath($configurePaths[0] . '/../') . '/');
defined('APPLICATION_ROOT') || define('APPLICATION_ROOT', realpath(APPLICATION_DIR . '/../') . '/');
defined('DEBUG_MODE') || define('DEBUG_MODE', true);

$configures = array();

/** This configures can access from template files */
$configures['application'] = array(
    'company_name' => '%application.company_name%',
    'root_admin' => false,
    'path_dir' => './',
    'static_server' => './media',
    'upload_server' => '../data/upload',
    'theme_data' => array(
        'login_theme_id' => 'black',
        'theme_id' => 'black',
        'navigation_id' => 'horizontal-top',

    ),
);

$configures['database'] = array(
    'write_adapter_name' => '%database.write_adapter_name%',
    'table_prefix' => '%database.table_prefix%',
    'adapters' => array(
        'master' => array(
            'host' => '%database.master.host%',
            'username' => '%database.master.username%',
            'password' => '%database.master.password%',
            'dbname' => '%database.master.username%',
            'charset' => '%database.master.charset%',
        )
    )
);

$configures['queue'] = array(
    'class' => '\\Puja\\Library\\Queue\\Provider\\Db\\Queue',
);

/** PLEASE DO NOT TOUCH IF YOU ARE NOT SURE */
$configures['cache_dir'] = APPLICATION_ROOT . '/../data/cache/bob/';
$configures['alice_cache_dir'] = APPLICATION_ROOT . '/../data/cache/alice/';
$configures['upload_config'] = array(
    'uploadDir' => APPLICATION_ROOT . '/../data/upload/',
);
$configures['router'] = array(
    'root_namespace' => '\\Puja\\Bob\\',
    'default_controller' => 'Index',
    'default_action' => 'index',
    'exclude_action' => array('beforeLoad', 'afterLoad'),
    'controller_dir' => APPLICATION_DIR . '/src/Controller/',
    'module_dir' => APPLICATION_DIR . '/src/Module/',
    'cache_dir' => APPLICATION_ROOT . '/../data/cache/bob/',
);
$configures['TemplateEngine'] = array(
    'templateDirs' => array(
        'Core' => APPLICATION_DIR . 'templates',
        //'Default' => APPLICATION_DIR . 'templates/Default',
    ),
    'cacheDir' => APPLICATION_ROOT . '/../data/cache/bob/',
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
    'error_template' => APPLICATION_DIR . 'templates/500.tpl',
    // 'callback_fn' => array(new A(), 'b'))
);
$configures['application'] = array_merge($configures['application'], array(
    'request_uri' => 'REQUEST_URI',
    'Bootstrap' => '\\Puja\\Bob\\Middleware\\Bootstrap',
    'View' => '\\Puja\\Middleware\\View',
    'Route' => '\\Puja\\Bob\\Middleware\\Route',
    'error404' => array('controller' => '\\Puja\\Bob\\Controller\\IndexController', 'action' => '\\Puja\\Bob\\Action\\Index\\Error404', 'annotation' => true),
));

$configures['Session'] = array(
    'saveHandler' => 'File', // default is File, you also can write saveHandler by your self
    'enabled' => false, // enabled Puja handle session system, if not the default session system will be used
    'ttl' => 0, // the number seconds session will be expired
    'options' => array(), // a list of session.* in php.ini, visit http://php.net/manual/en/session.configuration.php for full list
    'saveHandlerDir' => null, // the namespace to your SaveHandler folder, default: \Puja\Session\SaveHandler\
);


/** For BOB ONLY */
$configures['FieldTypes'] = array(
    'general' => array(
        'input' => 'Input Text',
        'multi_input' => 'Multi Input',
        'textarea' => 'Textarea',
        'multi_textarea' => 'Multi Textarea',
        'bbcode' => 'BBCode Editor',
        'wysiwyg' => 'WYSIWYG Editor',
        'wysiwyg_simple' => 'WYSIWYG Simple',
        'file' => 'File Upload',
        'file_img' => 'Image Upload',
        'date' => 'Input Date (YYYY-mm-dd)',
        'datetime' => 'Input Datetime (YYYY-mm-dd H:i:s)',
        'time' => 'Input Time (H:i:s)',
        'password' => 'Password',
        'switch_button' => 'SwitchButton',
        'static_option' => 'Static options',
        'dynamic_option' => 'Dynamic options',
        //'gallery' => 'Gallery Images',
    ),
    'static_options' => array(
        'radio' => 'Radio',
        'checkbox' => 'Checkbok',
        'select' => 'Select',
        'select_multi' => 'Select multi',
    ),
    'dynamic_options' => array(
        'datagrid_list' => 'Data Grid - List (Less data)',
        'datagrid_search' => 'Data Grid - Search (Big data)'
    ),
);

$configures['EasyUITheme'] = array(
    'default' => 'Default',
    'black' => 'Back',
    'bootstrap' => 'Bootstrap',
    'gray' => 'Gray',
    'material' => 'Material',
    'metro' => 'Metro',
);

$configures['NavigationTheme'] = array(
    'horizontal-top' => 'Horizontal Top',
    'horizontal-bottom' => 'Horizontal Bottom',
    'vertical-left' => 'Vertical Left',
    'vertical-right' => 'Vertical Right',
);
