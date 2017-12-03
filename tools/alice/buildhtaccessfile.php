<?php

if (file_exists(__DIR__ . '/../../.htaccess')) {
    echo 'File .htaccess exists already in ' . realpath(__DIR__ . '/../../') . PHP_EOL;
    exit;
}
$configurePaths = array(
    __DIR__ . '/../../application/alice/'
);
include __DIR__ . '/../../application/alice/config/configure.php';
include __DIR__ . '/../../application/alice/config/configure_local.php';

$pathDir = explode('index.php', $configures['application']['path_dir']);
$rootFile = $pathDir[0] . 'index.php';

$htaccessContent = <<<HTACCESSBODY
RewriteEngine Off
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule . {$rootFile} [L]
HTACCESSBODY;

$fp = fopen(__DIR__ . '/../../.htaccess', 'w');
fwrite($fp, $htaccessContent);
fclose($fp);

echo 'File .htaccess has been created successfully in ' . realpath(__DIR__ . '/../../') . PHP_EOL;
echo '=================.htaccess==============' . PHP_EOL;
echo $htaccessContent . PHP_EOL;
echo '=================END FILE===============' . PHP_EOL;
exit;