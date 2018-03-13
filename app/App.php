<?php
namespace App;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Modules\Base; 
use Modules\Auth; 
use Modules\Buildings; 
use Modules\Map; 

class App {
    private $router = null;
    private $modules = [];
    public static function start() {
        $router = new RouteCollector();
        Auth\Urls::register($router);
        Buildings\Urls::register($router);
        Map\Urls::register($router);
        $dispatcher = new Dispatcher($router->getData());
        $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        return $response;
    }
}
