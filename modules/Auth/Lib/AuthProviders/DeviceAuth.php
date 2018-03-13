<?php
namespace Modules\Auth\Lib\AuthProviders;
use  Modules\Auth\Lib\AuthProviders\AuthDataContainer as DataContainer;
use Modules\Auth\Models\LocalUser;

class DeviceAuth implements AuthProvider {

    public function authorise($id_token) : DataContainer { 
        // id_token is  device id
        $user = LocalUser::where(['code'=>$id_token])->firstOrFail();
        $user->token = base64_encode(md5(uniqid(random_int(0,999))).' '.$user->user_id);
        $user->code  = null;
        $user->save();
        $result = AuthDataContainer::create($user->user_id,$user->token,null);
        return $result;
    }
}

?>
