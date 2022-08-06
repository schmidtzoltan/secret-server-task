<?php


// path constants
define('BASE_PATH', realpath(".."));
define("APP_PATH", BASE_PATH . "/app");
define("CONFIG_PATH", APP_PATH . "/config");

require_once APP_PATH . "/System.php";

$system = new Project\System();

$system->start();