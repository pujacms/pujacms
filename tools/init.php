<?php
echo '============ Run composer: ' . PHP_EOL;
echo '* Alice PHP' . PHP_EOL;
echo `composer install -d application/alice`;
echo '* Alice Media' . PHP_EOL;
echo `composer install -d media`;
echo '* Bob PHP' . PHP_EOL;
echo `composer install -d application/bob`;
echo '* Bob Media' . PHP_EOL;
echo `composer install -d cms`;
echo '* Common libraries' . PHP_EOL;
echo `composer install`;

echo 'Composer install finish' . PHP_EOL;
echo 'Copy alice configure template ....';
if (file_exists('application/alice/config/configure_local.php')) {
    echo 'SKIP' . PHP_EOL;
} else {
    `cp application/alice/config/configure_local.template.php application/alice/config/configure_local.php`;
    echo 'OK' . PHP_EOL;
}

echo 'Copy bob configure template ....';
if (file_exists('application/alice/config/configure_local.php')) {
    echo 'SKIP' . PHP_EOL;
} else {
    `cp application/bob/config/configure_local.template.php application/bob/config/configure_local.php`;
    echo 'OK' . PHP_EOL;
}
echo 'Note: if you want to create .htaccess, configure application/alice/configure_local.php then run: php tools/alice/buildhtaccessfile.php' . PHP_EOL;