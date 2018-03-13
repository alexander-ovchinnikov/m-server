<?php
namespace Modules\Auth\Lib\AuthProviders;


final class AuthDataContainer {
    public $user_id;
    public $token;
    public $expires;

    public static function create($user_id, $auth_token, $expires) : self {
        $item = new self();
        $item->user_id = $user_id; 
        $item->token   = $auth_token;
        $item->expires = $expires;
        return $item;
    }
}
