<?php
namespace App;
use App\Cacher as Cacher;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\Container;


final class Settings {

    #set this files in config.php and move before debploy
    const DB_DRIVER = 'pgsql';
    const DB_HOST   = 'localhost';
    const DB_NAME   = 'main';
    const DB_USER   = 'root';
    const DB_PORT   = '5432';
    const DB_CHARSET= 'utf8';
    const DB_PASS   =  '';
    static $connection = null;
    static $prepared   = false;




    public static function init() {
        if (self::$prepared == true) {
            return;
        }
        self::$connection = new Capsule();
        self::$connection->addConnection([
            'driver'    => self::DB_DRIVER,
            'host'      => $_ENV["DB_HOST"] ?? self::DB_HOST,
            'database'  => $_ENV["DB_NAME"] ?? self::DB_NAME,
            'username'  => $_ENV["DB_USER"] ?? self::DB_USER,
            'port'      => $_ENV["DB_PORT"] ?? self::DB_PORT,
            'charset'   => $_ENV["DB_CHARSET"] ?? self::DB_CHARSET,
            'password'  => $_ENV["DB_PASS"] ?? self::DB_PASS
        ]);
        self::$connection->bootEloquent();
        self::$connection->setAsGlobal();
        self::$prepared = true;
        //Cacher::init();
    }
}
?>
