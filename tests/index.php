<?php 

require_once __DIR__ . "/../vendor/autoload.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$t = new Query\SourceEngine("91.224.117.164", 27015);

print_r($t->info);
