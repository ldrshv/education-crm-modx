<?php
require MODX_CORE_PATH . "config/config.inc.php";
require_once MODX_CORE_PATH . "app/vendor/autoload.php";
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection([
    "driver" => $database_type,
    "host" => $database_server,
    "database" => $dbase,
    "username" => $database_user,
    "password" => $database_password,
    'prefix' => $table_prefix,
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();