<?php
include __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/vendor/alice/autoload.php';
$app = new \Puja\Middleware\Application(__DIR__ . '/application/alice/');
$app->run();