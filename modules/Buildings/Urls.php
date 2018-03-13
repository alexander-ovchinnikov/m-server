<?php
namespace Modules\Buildings;
use Phroute\Phroute\RouteCollector;
use Modules\Base\BaseUrls;

class Urls extends BaseUrls{ # extends Common\Urls {
    public static function RegisterModuleRoutes( RouteCollector &$router  ) : bool {


        $router->any('/test/transaction', function() {
           return Controllers\BuildingController::testTransaction();
        },['before'=>'auth']);

        $router->any('/promotion/price', function() {
           $user_id = static::$user_id;
           $resource = $_POST['r'];
           return Controllers\BuildingController::getPromotionPrice($resource);
        },['before'=>'auth']);

       /**
        * @api {post} /user/activity/accelerate accelerate 
        * @apiName AccelerateActivity
        * @apiGroup Activities
        * @apiDescription accelerate user activity
        * @apiParam {Number} activity_id
        *
        * @apiHeader {String} HTTP_AUTHORIZATION  Auth token
        * @apiSuccess {String} id created activity id 
        */

        $router->any('/user/activity/accelerate', function() {
           $user_id = static::$user_id;
           $id = $_POST['activity_id'];
           return Controllers\BuildingController::userForceActivity($user_id, $id);
        },['before'=>'auth']);


       /**
        * @api {post} /user/activity/start start
        * @apiName Start activity
        * @apiGroup Activities
        * @apiDescription start activity
        * @apiParam {Number} object_id 
        * @apiParam {Number} activity_type
        *
        * @apiHeader {String} HTTP_AUTHORIZATION  Auth token
        * @apiSuccess {String} id created activity id 
        */
        

        $router->any('/user/activity/start', function() {
           $user_id = static::$user_id;
           $activity_id = $_POST['activity_id'];
           $object_id = $_POST['object_id'];
           return Controllers\BuildingController::userStartActivity($user_id, $object_id, $object_id);
        },['before'=>'auth']);
        /**
        * @api {post} /user/building/get get
        * @apiName GetBuilding
        * @apiGroup Building
        * @apiDescription Get user building
        * 
        * @apiHeader {String} HTTP_AUTHORIZATION  Auth token
        *
        * @apiSuccess {String} auth token for future requests 
        */

        $router->any('/user/building/get', function() {
           $user_id = static::$user_id;
           return Controllers\BuildingController::userGetBuildings($user_id);
        },['before'=>'auth']);

       /**
        * @api {post} /user/building/build build
        * @apiName BuildBuilding
        * @apiGroup Building
        * @apiDescription Build Building
        * 
        * @apiParam {Number} type_id 
        * @apiParam {Number} level 
        * @apiParam {Number} flipped
        * @apiParam {Number} location_id 
        * @apiParam {Number} x
        * @apiParam {Number} y 
        *
        * @apiHeader {String} HTTP_AUTHORIZATION  Auth token
        *
        * @apiSuccess {Number} id of a new created object 
        */

        $router->any('/user/building/build',function() {
            $user_id =static::$user_id;
            $type_id = $_POST['type_id'];
            $position= json_encode([
                "x"=>(int)@$_POST["x"],
                "y"=>(int)@$_POST["y"],
                "z"=>(int)@$_POST["z"],
            ]); 
            $flipped = $_POST['flipped'];
            $location_id = $_POST['location_id'];
            return Controllers\BuildingController::userBuildBuilding($user_id,$type_id,$position,$flipped,$location_id);
        },['before'=>'auth']);

       /**
        * @api {post} /user/activity/finish/building finish
        * @apiName finishBuilding
        * @apiGroup activities
        * @apiDescription finish user activity
        * 
        * @apiParam {number} building id 
        *
        * @apiHeader {string} http_authorization  auth token
        *
        */

        $router->any('/user/activity/finish/building',function() {
            $user_id     = static::$user_id;
            return ['rewards'=>Controllers\BuildingController::finishActivity(
                $user_id,
                $activity_id
            )];
        },['before'=>'auth']);

       /**
        * @api {post} /user/activity/finish finish
        * @apiname FinishActivity
        * @apigroup Activities
        * @apidescription finish user activity
        * 
        * @apiparam {number} activity_id 
        *
        * @apiheader {string} http_authorization  auth token
        *
        */
        $router->any('/user/activity/finish',function() {
            $user_id     = static::$user_id;
            $activity_id = $_POST['activity_id'];
            return ['rewards'=>Controllers\BuildingController::finishActivity(
                $user_id,
                $activity_id
            )];
        },['before'=>'auth']);


       /**
        * @api {post} /user/activities get
        * @apiName GetActivities
        * @apiGroup Activities
        * @apiDescription Finish User activity
        * 
        *
        * @apiHeader {String} HTTP_AUTHORIZATION  Auth token
        *
        * @apiSuccess {Object[]} activities list
        * @apiSuccess {Integer} activities.id activity id 
        * @apiSuccess {id} activities.game_object_id game_object_id 
        * @apiSuccess {Integer} progress progress from 1 to 0 
        */
        $router->any('/user/activities',function() {
            $user_id = static::$user_id;
            return ['activities'=>Controllers\BuildingController::userGetActivities(
                $user_id
            )];
        },['before'=>'auth']);



       /**
        * @api {post} /user/building/{building_id}/upgrade upgrate
        * @apiName UpgradeBuilding
        * @apiGroup Building
        * @apiDescription upgrade
        *
        * @apiHeader {String} HTTP_AUTHORIZATION  Auth token
        *
        * @apiSuccess {String} result  (ok)
        */
        $router->any('/user/building/{building_id}/upgrade',function($building_id) {
            $user_id = static::user_id;
            return Controllers\BuildController::userUpgradeBuilding($user_id, $building_id);
        },['before'=>'auth']);


       /**
        * @api {post} /user/building/{building_id}/destroy destroy
        * @apiName DestroyBuilding
        * @apiGroup Building
        * @apiDescription Destroy Building by id
        *
        * @apiHeader {String} HTTP_AUTHORIZATION  Auth token
        *
        * @apiSuccess {String} result  (ok)
        */
        $router->any('/user/building/{building_id}/destroy',function($building_id) {
            $user_id = static::user_id;
            return Controllers\BuildController::userDestroyBuilding($user_id, $building_id);
        },['before'=>'auth']);

        return true;
    }
} 
