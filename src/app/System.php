<?php

namespace Project;

use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Project\Di as ProjectDi;

class System {

    protected $_config;

    public function start()
    {
        // loader
        $loader = new Loader();
        $loader->registerDirs([
            APP_PATH . $this->getConfig()->application->controllersDir,
            APP_PATH . $this->getConfig()->application->modelsDir,
        ]);
        $loader->registerNamespaces([
            'Project' => APP_PATH . '/'
        ]);
        $loader->register();
        
        // dependency injector
        $di = new ProjectDi();
        
        // application handler
        $application = new Application($di);
        
        // request handling
        try {
            $response = $application->handle($_SERVER["REQUEST_URI"]);
            $response->send();
        } catch (\Exception $e) {
            echo 'Exception: ', $e->getMessage();
        }
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

