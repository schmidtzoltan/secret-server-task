<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\View;
use Phalcon\Url;

// path constants
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

$directories = [
    APP_PATH . '/controllers/',
    APP_PATH . '/models/',
];

// loader
$loader = new Loader();
$loader->registerDirs($directories);
$loader->register();

// dependency injector
$di = new FactoryDefault();
$di->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');

        return $view;
    }
);
$di->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');

        return $url;
    }
);

// application handler
$application = new Application($di);

// request handling
try {
    $response = $application->handle($_SERVER["REQUEST_URI"]);
    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}