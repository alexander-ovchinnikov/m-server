<?php
namespace App;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

class Cacher {
    private static $stored = [];
    private static $cache  = null;
    const PORT = 11211;
    const HOST = 'localhost';
    const EXPIRATION = 60;
    public  static function init() {
        self::$cache = new \Memcached();
        self::$cache->addServer(static::HOST, static::PORT);
    }
    
    public static function forget($key, $group) {
        self::$cache->delete($group . '_' . $key);
        unset(self::$stored[$group][$key]);
    }


    public static function get($key, $group, $method, $time) {
        $result =  self::$cache->get($group . '_' . $key);
        if (!$result) {
            $result = $method();
            self::$cache->set($group . '_' . $key, $result,$time);
            self::$stored[$group][]=$key;
        }
        return $result;
    }

    public static function process( $key,$group, $method, $affects=[], $time = 60) {
        foreach($affects as $affected_group) {
            if (isset(self::$stored[$affected_group])) {
                foreach(self::$stored[$affected_group] as $stored_key) {
                    self::forget( $stored_key, $affected_group);
                }
            }
        }
        
        return self::get($key,$group, $method, $time);
    }
}
