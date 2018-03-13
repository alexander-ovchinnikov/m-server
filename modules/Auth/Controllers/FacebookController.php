<?php
namespace Modules\Auth\Controllers;
use Modules\Auth\Models\Account;
use Modules\Auth\Models\User;
use Modules\Auth\Models\LocalUser;
use Modules\Auth\Lib\AuthProviders\DeviceAuth;

class FacebookController { # extends Common\Urls {
    const API_URL = "https://graph.facebook.com/";
    public static function getInfo($token) {
        $user_id = explode(' ',base64_decode($token))[1];
        $user = User::where(['user_id'=>$user_id,'token'=>$token])->firstOrFail()->toArray();
        $user['locations']=["foo","bar"];
        return $user;
    }

    public static function feed($token,$message) {
        $result  = self::postData($token, ['message'=>$message], 'me', '/feed');
        return true;
    }

    private static function postData( $token, $data ,  $user = 'me', $action = '' ) {
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
            ],
        ]);
        return json_decode(file_get_contents(
            self::API_URL . "/"
            . $user 
            . $action
            . "?" . http_build_query($data)
            . "&access_token=" . $token
            ,false , $context
        ),true);
    }

    private static function getData( $token, $fields = ['id'] ,  $user = 'me', $action = '' ) {
        return json_decode(
            file_get_contents(self::API_URL . "/"
                . $user
                . $action
                . "?fields="
                . implode(',',$fields)
                . "&access_token=".$token
            ), true);
    }

    private static function getAccount($token) {
        $token_data = AuthController::decodeToken($token);
        $account = Account::where(['user_id'=>$token_data['user_id'],'platform_id'=>AuthController::FACEBOOK])->first();
        return $account;
    }


    public static function getFriends( $token ) {
        $account  = self::getAccount($token);
        //$account = Account::firstOrFail(
        //    [
        //        'user_id'    =>$token_data['user_id'],
        //        'platform_id'=>AuthController::FACEBOOK
        //    ]
        //);
        $data = self::getData($account->token,['id','friends']);
        return $data;
    }

    public static function connect($platform_id,$platform_user_id,$token,$local_token) {
        $token_data = AuthController::decodeToken($local_token);
        $local_user_id = $token_data['user_id'];

        $data = self::getData($token);

        //$data = file_get_contents(self::API_URL . "/me?fields=id&access_token=".$token);

        if ($data['id']!=$platform_user_id) {
            return false;
        }

        $account = Account::firstOrNew([
            'platform_id'       => $platform_id,
            'platform_user_id'  => $platform_user_id,
            'user_id'           => $local_user_id
        ]);
        $account->token = $token;
        $account->save();
        return true;
    }

}


