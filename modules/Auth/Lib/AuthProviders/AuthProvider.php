<?php
namespace Modules\Auth\Lib\AuthProviders;
use  Modules\Auth\Lib\AuthProviders\AuthDataContainer;


interface AuthProvider {
    public function authorise($id_token) : AuthDataContainer;
}

?>
