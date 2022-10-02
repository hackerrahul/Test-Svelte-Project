<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('ENCRYPTION_KEY', 'syrow_iwudiwgedwe@@!#$%^&*()');


include_once(__DIR__."/../vendor/autoload.php");

$db = new MysqliDb ('localhost', 'root', 'root', 'server_manager');