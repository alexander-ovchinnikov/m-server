<?php
namespace Modules\Auth\Lib\AuthProviders;
use  Modules\Auth\Lib\AuthProviders\AuthProvider as DataContainer;

class GoogleAuth implements AuthProvider {
    const  CLIENT_ID  = 'XXXXX';

    public function authorise ($id_token) : DataContainer {
        $client = new Google_Client(['client_id' => self::client_id]);
        $payload = $client->verifyIdToken($id_token);
        if ($payload) {
          $userid = $payload['sub'];
          // If request specified a G Suite domain:
          //$domain = $payload['hd'];
          $token = DataContainer::create($userid,$id_token,$payload['exp']);
          return $token;
        } else {
            throw new Exception();
        }
        # expires in exp
    }
}
