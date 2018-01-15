<?php
include __DIR__ . '/application/vendor/autoload.php';
include __DIR__ . '/application/vendor/alice/autoload.php';
$app = new \Puja\Middleware\Application(__DIR__ . '/application/alice/');
$app->run();