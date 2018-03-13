<?php
namespace Modules\Auth;
use Phroute\Phroute\RouteCollector;
use Modules\Base\BaseUrls;

class Urls extends BaseUrls{ # extends Common\Urls {
    public static function RegisterModuleRoutes( RouteCollector &$router  ) : bool {
        $router->any('/test/get',function() {
            return Controllers\AuthController::testGet();
        });

        /**
         * @api {post} /auth/feed Feed a post
         * @apiName  Feed
         * @apiGroup Social
         * @apiParam {Number} platform_id Platform identifier
         * @apiParam {String} message Message to  feed
         * @apiParam  {String}  token post token provided by platform 
         * @apiHeader {String} HTTP_AUTHORIZATION
         * @apiSuccess {Boolean} result
         */
         $router->any('/user/feed',function() {
             $platform_id = $_POST['platform_id'];
             $message     = $_POST['message'];
             $token       = $_POST['token'];
             //$token= $_SERVER[BaseUrls::AUTH_HEADER_NAME];
             $result = false;
             if ($platform_id == Controllers\AuthController::FACEBOOK) {
                 $result =  Controllers\FacebookController::feed($token,$message);
             }
             return [
                 'result'=>$result
             ];
         });//,['before'=>'auth']);

        /**
         * @api {post} /user/friends Get User Friends on Platform
         * @apiName  Friends
         * @apiGroup Social
         * @apiHeader {String} HTTP_AUTHORIZATION
         */
         $router->any('/user/friends',function() {
             $token= static::$access_token_full; //$_SERVER[BaseUrls::AUTH_HEADER_NAME];
             return Controllers\FacebookController::getFriends($token);
         });//,['before'=>'auth']);

       /**
        * @api {post} /auth/login get access token with device_id code
        * @apiName  GetToken
        * @apiGroup Auth
        * 
        * @apiParam {Number} platform_id Platform identifier
        * @apiParam {String} code   Auth code recieved from platform
        *
        * @apiSuccess {String} token token for future requests with social access code
        * @apiSuccess {String} expires 
        * @apiSuccess {String} user_id 
        */

       /**
        * @api {post} /auth/login get access token with device id only
        * @apiName  GetToken 
        * @apiGroup Auth
        * @apiParam {String} device_id 
        * @apiSuccess {String} token token for future requests 
        * @apiSuccess {String} expires 
        * @apiSuccess {String} user_id 
        */

        $router->post('/auth/login', function() {
            $request=$_POST;
            if (isset($request['device_id'])) {
                $platform_id = Controllers\AuthController::DEVICE;
                $token       = Controllers\AuthController::getCode($request);
            } else {
                $platform_id = $request['platform_id'];
                $token       = $request['code'];
            }
            return Controllers\AuthController::getToken($platform_id, $token); 
        });


       /**
        * @api {post} /auth/connect Connect external platform
        * @apiName  Connect
        * @apiGroup Social
        * 
        * @apiParam {Number} platform_id 
        * @apiParam {String} token External Platform Token 
        * @apiParam {String} user_id platform user id 
        * 
        * @apiHeader {String} HTTP_AUTHORIZATION  Auth token
        * @apiSuccess {String} user_id 
        * 
        */
        $router->any('/auth/connect', function() {
            $local_token = static::$access_token_full;// $_SERVER[BaseUrls::AUTH_HEADER_NAME];
            $platform_id=$_POST['platform_id'];
            $user_id=$_POST['user_id'];
            $token=$_POST['token'];

            $result = Controllers\FacebookController::connect($platform_id,$user_id,$token,$local_token);
            return [
                'result'=>$result
            ];
        });


       /**
        * @api {post} /auth/token/update Update Token
        * @apiName  UpdateToken
        * @apiGroup Auth
        * 
        * @apiParam {String} device_id 
        * 
        * @apiHeader {String} HTTP_AUTHORIZATION  Auth token
        * 
        * @apiSuccess {String} token New AccessToken 
        */
        $router->any('/auth/token/update', function() {
            $token =  static::$access_token_full;//@$_SERVER[BaseUrls::AUTH_HEADER_NAME];
            return Controllers\AuthController::updateToken($token);
        });

        $router->any('/auth/token', function() {
            $request=$_POST;
            $token = static::$access_token_full;// @$_SERVER[BaseUrls::AUTH_HEADER_NAME];
            if ($token)  {
                $result = Controllers\AuthController::updateToken($token);
                if ($result) {
                    return $result;
                }
            }
            if (isset($request['device_id'])) {
                $platform_id = Controllers\AuthController::DEVICE;
                $token       = Controllers\AuthController::getCode($request);
            } else {
                $platform_id = $request['platform_id'];
                $token       = $request['code'];
            }
            return Controllers\AuthController::getToken($platform_id, $token); 
        });

        /**
         * @api {post} /auth/code get local auth code
         * @apiName  GetCode
         * @apiGroup Auth
         *
         * @apiParam {String} device_id Device unique id
         * @apiSuccess {String} code Authorisation Code
         */

        $router->any('/auth/code/',function() {
            $data = static::getRequest()['post'];
            return [
              'code'=>Controllers\AuthController::getCode($data)
            ];
         });
       
        /**
         * @api {post} /auth/migrate migrate to a platform
         * @apiName  Migrate
         * @apiGroup Auth
         * @apiParam {String} platform_id Platform Identefier 
         * @apiParam {String} code Auth code provided by platform
         * @apiSuccess {Boolean} result 
         */
         $router->get('/auth/migrate',function() {
            $request=$_POST;
            $local_token = static::$access_token_full;//$_SERVER[BaseUrls::AUTH_HEADER_NAME];
            $platform_id = $request['platform_id'];
            $token       = $request['code'];
             return Controllers\AuthController::migrate($platform_id,$token,$local_token);
         },['before'=>'auth']);

        /**
         * @api {post} /user/info get user info
         * @apiName  UserInfo
         * @apiGroup Auth
         * @apiSuccess {Number} user_id
         * @apiSuccess {String} name
         * @apiSuccess {Number} coins
         * @apiSuccess {Object[]} user_info
         * @apiSuccess {Number} user_info.user_id
         * @apiSuccess {String} user_info.token
         * @apiSuccess {String} user_info.expiration_ts
         * @apiSuccess {String} user_info.name
         * @apiSuccess {Number} user_info.coins
         * @apiSuccess {Object[]} user_info.buildings
         * @apiSuccess {Number} user_info.buildings.id
         * @apiSuccess {String} user_info.buildings.type
         * @apiSuccess {Number} user_info.buildings.passability
         * @apiSuccess {Object} user_info.buildings.data
         * @apiSuccess {Object} user_info.buildings.data.origin
         * @apiSuccess {Number} user_info.buildings.data.origin.x
         * @apiSuccess {Number} user_info.buildings.data.origin.y
         * @apiSuccess {Number} user_info.buildings.data.origin.z
         * @apiSuccess {Object} user_info.buildings.data.size
         * @apiSuccess {Number} user_info.buildings.data.size.x
         * @apiSuccess {Number} user_info.buildings.data.size.y
         * @apiSuccess {Number} user_info.buildings.data.size.z
         * @apiSuccess {Number} user_info.buildings.data.sort_position
         * @apiSuccess {Number} user_info.buildings.data.flipped
         * @apiSuccess {Number} user_info.buildings.data.sprite
         * @apiSuccess {String} user_info.buildings.data.__type
         * @apiSuccess {String[]} user_info.locations
         *
         *
         */
        $router->any('/user/info',function() {
            $token = static::$access_token_full; //$_SERVER[BaseUrls::AUTH_HEADER_NAME];
            return Controllers\UserController::getInfo($token);
        }
         ,['before'=>'auth']
        );


        return True;




    }
} 
