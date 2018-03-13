<?php
namespace Modules\Auth\Controllers;
use Modules\Auth\Models\Account;
use Modules\Auth\Models\User;
use Modules\Auth\Models\LocalUser;
use Modules\Auth\Lib\AuthProviders\DeviceAuth;
use Illuminate\Database\Capsule\Manager as Capsule;
#use Modules\Auth\Lib\AuthProviders\DeviceAuth;



class AuthController { # extends Common\Urls {
    const E_ALREADY_EXISTS = 'User alredy Exists';
    private $authenticator;
    const DEVICE     = 1;
    const GOOGLE     = 2;
    const FACEBOOK   = 3;
    const DEFAULT_USER_NAME = "Doe";

    # /user/build/1

    public static function testGet() {
        Capsule::enableQueryLog();
        echo '<pre>';
        $user = User::with('buildings')->get()->first()->toArray();
        var_dump($user);
        //var_dump(Capsule::getQueryLog());
        die('#');
    }

    public static function updateToken($access_token) {
        $user_id = self::decodeToken($access_token)['user_id'];
        $user = User::where(['user_id'=>$user_id])->firstOrFail(); 
        $user->expiration_ts = date('Y-m-d H:i:s');
        $user->token = self::generateToken($user->user_id);
        $user->save();
        return ['token'=>$user->token,'expired'=>$user->expirations_ts,'user_id'=>$user->id];
    }

    public static function getInfo($token) {
        $user_id = explode(' ',base64_decode($token))[1];
        $user = User::with('buildings')->where(
            [
                'user_id'=>$user_id,
                'token'  =>$token
            ])->firstOrFail()->toArray(); 
        error_log('>>>');
        error_log($user);
        return $user;
        //$user_locations = UserLocations::where(['user_id'=>$user_id])->get()->toJson();
    }

    public static function getCode($credentials) : string {
        $id = @$credentials['device_id'];
        if (!$id) {
            throw new \Exception('No valid code was provided');
        }
        $result =  LocalUser::getCode($id);
        return $result;
    }

    public static function getAuthProviderById($auth_provider_id) {
        switch ($auth_provider_id) {
            case self::GOOGLE:
                return new GoogleAuth();
                break;
            case self::DEVICE:
                return new DeviceAuth();
                break;
            default:
                throw new \Exception('No Valid Auth Provider Provided');
        }
    }


    public function isOwner($user_id,$token) {
        return $user_id == explode(' ',base64_decode($token))[1];
    }

    public static function isAuthed($token) {
        if (!$token) return false;
        $exploded = explode(' ',base64_decode($token));
        if (count($exploded)<2) {
            return false;
        }
        $user_id = (int)$exploded[1];
        $user = User::where(['user_id'=>$user_id])->firstOrFail();
        if ($user && $user->token == $token && $user->expiration_ts > date('Y-m-d H:i:s')) {
            return true;
        } else {
            return false;
        }
        return false;
    }




    private static function generateToken($user_id) {
        return base64_encode(md5(uniqid(random_int(0,999))).' '.$user_id);
    }


    private static function getAccontByAuthCode($platform_id, $auth_code) {
        $auth_provider_class = self::getAuthProviderById($platform_id);
        $auth_provider = new $auth_provider_class();
        $auth_data = $auth_provider->authorise($auth_code);

        if ($auth_data === null) {
            throw new \Exception('No valid auth_data provided');
        }


        $account->token = $auth_data->token;
        #$account->save();
        return $account;

    }

    public static function migrate($platform_id, $auth_code,$local_token) : string  {
        $account = self::getData($platform_id,$auth_code);
        $user_id = @explode(' ',base64_decode($token))[0];
        if (!$user_id) {
            throw new \Exception();
        }
        $account->user_id = $user->user_id;
        $account->save();
        return true;
    }
    


    /*
    public static function fbconnect($platform_id,$platform_user_id,$token,$local_token) {
        error_log($local_token);
        $token_data = self::decodeToken($local_token);
        error_log($token_data);
        $local_user_id = $token_data['user_id'];
        error_log($token);
        $fb_id = file_get_contents("https://graph.facebook.com/me?fields=id&access_token=".$token);
        if (@json_decode($fb_id,true)['id']!=$platform_user_id) {
            return false;
        }

        $account = Account::firstOrNew([
            'platform_id'       => $platform_id,
            'platform_user_id'  => $platform_user_id,
            'user_id'           => $local_user_id
        ]);
        $account->save();
        return true;
    }
     */

    public static function getToken($platform_id, $auth_code,$local_access_token = null) {
        $platform_user_id = null;
        if ($platform_id == self::GOOGLE) {
            $client = new \Google_Client();
            $client->setAuthConfig('./config.json');
            $client->authenticate($auth_code);
            $access_token = $client->getAccessToken();
            $token = $access_token['access_token'];
            $client->setAccessToken($token);
            $games = new \Google_Service_Games($client);
            $platform_user_id = @$games->players->get('me')->playerId;
            error_log($platform_user_id);
        } elseif ($platform_id == self::DEVICE ) {
            error_log($auth_code);
            error_log($platform_id);
            $platform_user_id = LocalUser::where(['code'=>$auth_code])->first()->user_id;
        } elseif ($platform_id == self::FACEBOOK) {

        }

        $account = Account::firstOrNew([
            'platform_id'       => $platform_id,
            'platform_user_id'  => $platform_user_id,
        ]);

        //$account = self::getAccontByAuthCode($platform_id,$auth_code);
        //
        if ($local_access_token) {
            $token_data = self::decodeToken($local_access_token);
            if ($token_data['id'] && $token_data['code']) {
                $user = User::where(['user_id'=>$user_id,'token'=>$local_access_token])->first();
            }
            $user = User::where(['user_id'=>$account->user_id])->first();
        } else {
            $user = User::where(['user_id'=>$account->user_id])->first();
        }

        if (!$account->user_id ) {
            if (@!$user) {
                $user   = new User();#::create(['token'=>'','expiration_ts'=>date('Y-m-d H:i:s')]);
                $user->name=self::DEFAULT_USER_NAME;
                $user->coins=0;
            }
            $user->save();
        }
        $user_id = $user->user_id;
        $account->user_id = $user_id;
        
        $exp = $user->expiration_ts = date('Y-m-d H:i:s',time()+60*60*24);
        $user->token = self::generateToken($user_id);
        $user->save();
        $account->save();
        $result = [
            'token'=>$user->token,
            'expires'=>$exp,
            'user_id'=>$user_id
        ];
        error_log('get_token');
        error_log(var_export($result,true));
        return $result;
    }

    public static function connect($auth_code, $platform_id) {
            //$code = $_GET['code'];
            $client = new \Google_Client();
            $client->setAuthConfig('./config.json');
            $client->authenticate($_GET['code']);
            $access_token = $client->getAccessToken();
            $token = $access_token['access_token'];
            $client->setAccessToken($token);
            $games = new \Google_Service_Games($client);
            $id = $games->players->get('me')->playerId;
    }
} 
