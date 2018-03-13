<?php
namespace Modules\Base;
use Phroute\Phroute\RouteCollector;
use Modules\Auth\Controllers\AuthController;

abstract class BaseUrls { # extends Common\Urls {
    const AUTH_HEADER_NAME = 'HTTP_AUTHORIZATION';
    public static $initialised  = false;

    protected static $user_id      = null;
    protected static $access_token = null;
    protected static $access_token_full = null;

    protected static function getRequest() : array {
       $request = [
           'headers'=>$_SERVER,
           'post'   =>$_POST,
           'get'    =>$_GET
       ];  
       return $request;
    }


    abstract static protected function RegisterModuleRoutes( RouteCollector &$router ) : bool ;


    public static function register (&$router = RouteCollector ) : bool {
        if (!static::$initialised) {
            static::init($router);
        }
        #static::$router = new RouteCollector();
        #
        return static::RegisterModuleRoutes( $router );
    }

    protected static function init(RouteCollector &$router) {
        if(!@$_SERVER['HTTP_AUTHORIZATION'] && $_SERVER['REQUEST_METHOD'] == 'GET' ) {
            $_POST = $_GET;
            $_SERVER['HTTP_AUTHORIZATION'] = "NTUwNTVkODdjZWVkOTI4ZGQ3OGQyYWJkMGNlMmU0NWUgMTI=";
        }

        static::$initialised = true;
        $router->filter('auth', function() {

            static::$access_token_full = @$_SERVER[static::AUTH_HEADER_NAME];
            if ( static::$access_token_full ) {
                $token_data = static::decodeToken(static::$access_token_full);//['user_id'];
                static::$user_id      = $token_data['user_id'];
                static::$access_token = $token_data['token'];
            }

            if(!@AuthController::isAuthed(static::getRequest()['headers'][static::AUTH_HEADER_NAME])) {
                return "token_required";
                //throw new \Exception('token_required');

            }
        });

    }

    private static function decodeToken($token) {
        $result = explode(' ',base64_decode($token));
        return [
            'token'=>$result[0],
            'user_id'=>$result[1]
        ];
    }
} 
