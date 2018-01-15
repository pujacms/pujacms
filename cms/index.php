<?php
include __DIR__ . '/../application/vendor/autoload.php';
include __DIR__ . '/../application/vendor/bob/autoload.php';
$app = new \Puja\Middleware\Application(__DIR__ . '/../application/bob/');
$app->run();