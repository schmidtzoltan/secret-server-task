<?php

namespace Project;

use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\View;
use Phalcon\Url;

class Di extends FactoryDefault {

    protected $_config;

    public function __construct()
    {
        $this->set('config', $this->getConfig());
        $this->set(
            'view',
            function () {
                $view = new View();
                $view->setViewsDir(APP_PATH . '/views/');
        
                return $view;
            }
        );
        $this->set(
            'url',
            function () {
                $config = $this->getShared('config');

                $url = new Url();
                $url->setBaseUri($config->application->baseUri);
        
                return $url;
            }
        );
        $this->set(
            'db',
            function () {
                return new Mysql([
                    'host'     => 'db', // same as name in docker-compose
                    'port'     => '3306',
                    'username' => getenv('MYSQL_USER'),
                    'password' => getenv('MYSQL_PASSWORD'),
                    'dbname'   => getenv('MYSQL_DATABASE'),
                ]);
            }
        );
        $this->set('eventsManager', function() {
            $eventsManager = new Manager();

            return $eventsManager;
        });
        $this->set('router', function () {
            $router = new Router();

            return $router;
        });
        $this->set('dispatcher', function () {
            $eventsManager = $this->getShared('eventsManager');

            $dispatcher = new Dispatcher();

            $dispatcher->setEventsManager($eventsManager);
            //$dispatcher->setDefaultNamespace('Project\\Controller');

            return $dispatcher;
        });
        $this->set('response', new Response());
    }

    public function getConfig(): ConfigIni
    {
        if (!$this->_config) {
            $this->_config = new ConfigIni( CONFIG_PATH . '/config.ini');
        }

        return $this->_config;
    }

    public function setConfig(ConfigIni $config): void
    {
        $this->_config = $config;
    }
}