<?php

class Config1{}

class Config{
    
    private static $instance = null;
    private $setting = [];
    private function __construct(){}
    private function __clone(){}

    public static function getInstance()
    {
        if(self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance;
    }    

    public function set($index, $value){
        $this->setting[$index] = $value;
    }

    public function get($index){
        return $this->setting[$index];
    }

}    
$obj1 = new Config1;
$obj2 = new Config1;
var_dump($obj1, $obj2);

$obj1 = Config::getInstance();
$obj2 = Config::getInstance();
var_dump($obj1, $obj2);

$obj1->set("host", "localhost");
echo $obj1->get("host");