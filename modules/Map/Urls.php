<?php
namespace Modules\Map;
use Phroute\Phroute\RouteCollector;
use Modules\Base\BaseUrls;

class Urls extends BaseUrls{ # extends Common\Urls {
    public static function RegisterModuleRoutes( RouteCollector &$router  ) : bool {

        $router->any('/map/',function() {
            $user_id = self::$user_id;
            $result = Controllers\MapController::Proto($user_id);
            return $result;
        },['before'=>'auth']);

        return true;
    }
}
