<?php 
namespace Modules\Auth;
class Module {

    public static function load() {

            #Settings::init();
            #if (!self::$router) {
            #    self::$router =  Auth\Urls::get();
            #}

            #$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());
            #$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }
}
?>
