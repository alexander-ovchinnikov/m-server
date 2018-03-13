<?php
error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once('./vendor/autoload.php');
use App\Settings as Settings;
use App\App as App;
Settings::init();

##error_log(var_export($_POST,true));
try {
    $result =  json_encode(App::start(),JSON_PRETTY_PRINT);
} catch (Exception $e) {
    error_log("Fail::"); 
    header("HTTP/1.0 406 Not Acceptable");
    $result = json_encode([
        'status' =>'error',
        'message'=>$e->getMessage(),
        'exception'=>var_export($e,true)
    ],JSON_PRETTY_PRINT);
}
    error_log("Success::"); 
    error_log(var_export($result,true)); 
    echo $result; 
    exit(0);
