<?php
// class Singleton{
//     //存放实例
//     private static $_instance = null;

//     //私有化构造方法、
//     private function __construct(){
//         echo "单例模式的实例被构造了";
//     }
//     //私有化克隆方法
//     private function __clone(){

//     }

//     //公有化获取实例方法
//     public static function getInstance(){
//         if (!(self::$_instance instanceof Singleton)){
//             self::$_instance = new Singleton();
//         }
//         return self::$_instance;
//     }
// }

// $singleton=Singleton::getInstance();

Trait Singleton{
    //存放实例
    private static $_instance = null;
    //私有化克隆方法
    private function __clone(){

    }

    //公有化获取实例方法
    public static function getInstance(){
        $class = __CLASS__;
        if (!(self::$_instance instanceof $class)){
            self::$_instance = new $class();
        }
        return self::$_instance;
    }
}

class DB {
    private function __construct(){
        echo __CLASS__.PHP_EOL;
    }
}

class DBhandle extends DB {
    use Singleton;
    private function __construct(){
        echo "单例模式的实例被构造了";
    }
}
$handle=DBhandle::getInstance();