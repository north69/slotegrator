<?php
define('PROJECT_ROOT', dirname(__DIR__));
require dirname(__DIR__).'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();