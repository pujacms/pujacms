# pujacms

Install:
Checkout out source code:
<pre>
git clone https://github.com/pujacms/pujacms.git
cd pujacms</pre>
Then run below commands:
<pre>
composer install
composer install -d application/alice/
composer install -d application/bob/
composer install -d cms/
composer install -d media/</pre>

Then create 2 configure file:
application/alice/config/configure_local.php
<pre>
<?php
$configures['application']['path_dir'] = '/pujacms/index/';
$configures['application']['static_server'] = '//localhost/pujacms/media';
$configures['application']['upload_server'] = '//localhost/pujacms/data/upload';
</pre>

application/bob/config/configure_local.php
<pre>
<?php
$configures['database'] = array(
    'write_adapter_name' => 'master',
    'table_prefix' => 'puja_',
    'adapters' => array(
        'master' => array(
            'host' => 'dbhost',
            'username' => 'dbusername',
            'password' => 'dbpassword',
            'dbname' => 'dbname',
            'charset' => 'utf8',
        )
    )
);

$configures['application']['company_name'] = 'PujaCMS';
$configures['application']['root_admin'] = true;
</pre>

Then import database from file: application/bob/migration/0-init.sql

Access your application by browser:
- Alice (FrontEnd page): http://localhost/pujacms/
- Bob (CMS page): http://localhost/pujacms/cms/

Thats it!

Related links <a href="https://git-scm.com/book/en/v2/Getting-Started-Installing-Git">Install Git</a>  <a href="https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx">Install Composer</a>




