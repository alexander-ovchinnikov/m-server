<?php
namespace Modules\Auth\Controllers;
use Modules\Auth\Models\Account;
use Modules\Auth\Models\User;
use Modules\Auth\Models\LocalUser;
use Modules\Auth\Lib\AuthProviders\DeviceAuth;

class UserController { # extends Common\Urls {
    public static function getInfo($token) {
        $user_id = explode(' ',base64_decode($token))[1];
        $user = User::with('buildings')->where(['user_id'=>$user_id,'token'=>$token])->firstOrFail()->toArray();
        $user['locations']=["",""];
        return $user;
        //$user_locations = UserLocations::where(['user_id'=>$user_id])->get()->toJson();
    }
}
