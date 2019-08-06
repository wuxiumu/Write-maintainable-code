<?php
abstract class Prototype{
    public function __construct($id){
        $this->id = $id;
    }
    public function __get($name){
        return $this->name;
    }
    public function __set($name, $value){
        $this->$name = $value;
    }
    public abstract function clone();
}

// 
class ConcreatePortotype extends Prototype{
    public function clone(){
        return clone $this;// 浅拷贝
    }
}

// 
class DeepCopyDemo{
    public $array;
}

$demo = new DeepCopyDemo();
$demo->array = array(1,2);
$obj1 = new ConcreatePortotype($demo);
$obj2 = $obj1->clone();
var_dump($obj1);
var_dump($obj2);
$demo->array = array(3, 4);
var_dump($obj1);
var_dump($obj2);