<?php
$rootDir = realpath(__DIR__ . '/../');
if (is_dir($rootDir)) {
    //die('Folder ' . realpath($rootDir) . ' is already existed' . PHP_EOL);
}

function buildDir($folder) {
    mkdir($folder);
    $fp = fopen($folder . '/.gitkeep', 'a');
    fclose($fp);
}

buildDir($rootDir . '/data');
$rootDir = $rootDir . '/data';
buildDir($rootDir . '/cache');
buildDir($rootDir . '/cache/alice');
buildDir($rootDir . '/cache/bob');
buildDir($rootDir . '/upload');
buildDir($rootDir . '/upload/thumb');
buildDir($rootDir . '/upload/original');
for ($i = 0; $i < 10; $i++) {
    buildDir($rootDir . '/upload/' . $i);
    buildDir($rootDir . '/upload/thumb/' . $i);
    buildDir($rootDir . '/upload/original/' . $i);
}
buildDir($rootDir . '/logs');