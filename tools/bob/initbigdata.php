<?php
include __DIR__ . '/../../application/bob/config/configure.php';
mysqli_connect(
    $configures['database']['adapters']['master']['host'],
    $configures['database']['adapters']['master']['username'],
    $configures['database']['adapters']['master']['password']
);
mysqli_select_db($configures['database']['adapters']['master']['dbname']);

function insertCategory($parentId = 0)
{
    for ($i = 1000; $i >= 0; $i--) {
        mysqli_query("INSERT INTO puja_category(fk_parent_category, order_id) values({$parentId},{$i})");
        $catId = mysqli_insert_id();
        mysqli_query("insert into puja_category_ln(fk_category, fk_configure_language, name) values({$catId}, 1, 'name{$i}')");
    }
}