<?php
include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../vendor/bob/autoload.php';
$app = new \Puja\Middleware\Application(__DIR__ . '/../application/bob/');
$app->run();