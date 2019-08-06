<?php

abstract class Operation{
    abstract public function getVal($i, $j);
}

// +
class OperationAdd extends Operation{
    public function getVal($i, $j){
        return $i + $j;
    }
}

// *
class OperationMul extends Operation{
    public function getVal($i, $j){
        return $i * $j;
    }
}

// abstract
abstract class Factor{
    abstract static function getInstance();
}

// abstract +
class AddFactor extends Factor{
    public static function getInstance(){
        return new OperationAdd;
    }
}

// abstract *
class MulFactor extends Factor{
    public static function getInstance(){
        return new OperationMul;
    }
}
// diy
class TextFactor extends Factor{
    public static function getInstance(){   }

}
$add = MulFactor::getInstance();
echo $add->getVal(9, 9);