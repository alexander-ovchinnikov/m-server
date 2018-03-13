<?php
use PHPUnit\Framework\TestCase;
use Modules\Auth as Auth;
use App\Cacher as Cacher;
use App\Settings as Settings;
use Modules\Auth\Controllers\AuthController as AuthController;

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;


final class AuthRouteTest extends TestCase {
        const DEVICE_ID = 'HOHOHO';
        protected static $capsule = null;
        protected static $router  = null;
        protected static $dispatcher = null;
        private function dispatch($router, $method, $uri) {
            self::$dispatcher = null;#new Dispatcher($router->getData());
            self::$dispatcher = new Dispatcher($router->getData());
            return self::$dispatcher->dispatch($method, $uri);
        }

        #public function testFoundAuth() {
        #    $router =  Auth\Urls::getModuleRouter();

        #    $this->assertEquals('login', 
        #        $this->dispatch($router,'POST', '/login')
        #    );
        #}

        
        protected function setUp() {
            Settings::init();
            if (!self::$router) {
                static::$router = new RouteCollector();
                Auth\Urls::register(static::$router);
            }
        }


        private function getToken() {
            $_POST['code']         = $this->getCode();
            $_POST['platform_id']  = AuthController::DEVICE;
            $result = $this->dispatch(self::$router, 'POST', '/auth/login');
            $this->assertInternalType('string',$result);
            return $result;

        }

        private function getCode() {
            $_POST['platform_id']  = AuthController::DEVICE;
            $_POST = [
                'device_id'=>self::DEVICE_ID
            ];
            $result = $this->dispatch(self::$router,'POST','/auth/code');
            $this->assertInternalType('string',$result);
            return $result;
        }

        public function testRouteLogin() {
            $_SERVER[Auth\Urls::AUTH_HEADER_NAME] = $this->getToken();
            $result = $this->dispatch(self::$router,'GET','/auth/logged');
            $this->assertTrue($result);
        }

        public function testFailLogin() {
            $_SERVER[Auth\Urls::AUTH_HEADER_NAME] = 'FO'; 
            $_POST = [];
            $result = $this->dispatch(self::$router,'GET','/auth/logged');
            $this->assertFalse($result);

        }

        public function testMemcached() {
            Cacher::forget('test','/do');
            $result1 = Cacher::process('/do', 'test', function() {
                    return 'value1' ;
                }, ['test'], 60, ['test']);

            $result2 = Cacher::process('/do', 'test',function() {
                    return 'value2' ;
                }, [], 60 );

            $this->assertEquals($result1,$result2);
            $this->assertEquals($result1,'value1');

            $result1 = Cacher::process('/do', 'test',function() {
                    return 'value1' ;
            }, ['test'], 60);
            $result2 = Cacher::process('/do', 'test',function() {
                    return 'value2' ;
            }, ['test'], 60);
            $this->assertNotEquals($result2,$result1);

        }

        public function testMigration() {
            $this->assertEquals(true,true);
        }

        public function testLogin() {
            $credentials = ['device_id'=>self::DEVICE_ID,'platform_id'=>AuthController::DEVICE];
            $platform_id = AuthController::DEVICE;
            $auth_code = AuthController::getCode($credentials);
            $this->assertInternalType("string",$auth_code);
            $token     = AuthController::login($platform_id,$auth_code);
            $this->assertTrue(AuthController::isAuthed($token));
        }
}

?>

