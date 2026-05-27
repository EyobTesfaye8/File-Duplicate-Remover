<?php
require_once './autoload.php';
use src\App;

$path = $argv[1];
$app = new App($path);
$app->start();