<?php

abstract class carModel{
    
    public $spareParts = [];
    public $carName = "";
    public abstract function addWheel($xinghao);
    public abstract function addShell($xinghao);
    public abstract function addEngine($xinghao);

    final public function getCar($carName){
        if($this->spareParts){
            $this->carName = $carName;
            foreach ($this->spareParts as $k => $v) {
                $actionName = "add".$k;
                $this->$actionName($v);
            }
        }else{
            throw new Exception("没有汽车部件🚗");
        }
    }
}

class bmwCarModel extends carModel{
    
    public $spareParts = [];
    public $carName = "";
    public function addWheel($xinghao){
        echo "宝马".$this->carName."的外壳，型号是".$xinghao."\n";
    }
    public  function addShell($xinghao){
        echo "宝马".$this->carName."的轮子，型号是".$xinghao."\n";
    }
    public  function addEngine($xinghao){
        echo "宝马".$this->carName."的发动机，型号是".$xinghao."\n";
    }
}
class benziCarModel extends carModel{

    public $spareParts = [];
    public $carName = "";

    public function addWheel($xinghao){
        echo "奔驰".$this->carName."的轮子，型号是" . $xinghao . "\n";
    }

    public function addShell($xinghao){
        echo "奔驰".$this->carName."的外壳，型号是" . $xinghao . "\n";
    }

    public function addEngine($xinghao){
        echo "奔驰".$this->carName."的发动机,型号是 " . $xinghao . "\n";
    }
}

abstract class carBuilder{
    public abstract function setSpareParts($partsName , $xinghao);

    public abstract function getCarModel($name);
}

class bmwBuilder extends carBuilder{
    private $bmwModel;

    public function __construct(){
        $this->bmwModel = new bmwCarModel();
    }

    public function setSpareParts($partsName , $xinghao){
        $this->bmwModel->spareParts[$partsName] = $xinghao;
    }

    public function getCarModel($name){
        $this->bmwModel->getCar($name);
    }
}


class benziBuilder extends carBuilder{
    private $benziModel;

    public function __construct(){
        $this->benziModel = new benziCarModel();
    }

    public function setSpareParts($partsName , $xinghao){
        $this->bmwModel->spareParts[$partsName] = $xinghao;
    }

    public function getCarModel($name){
        $this->bmwModel->getCar($name);
    }
}

$bmwBuilder = new bmwBuilder();
$bmwBuilder->setSpareParts('Wheel' , '牛逼轮子1号');
$bmwBuilder->setSpareParts('Shell' , '牛逼外壳1号');
$bmwBuilder->setSpareParts('Engine' , '牛逼发动机1号');
$bmwBuilder->getCarModel("宝马x1"); 
$bmwBuilder->getCarModel("宝马x1");  //连续创建两个宝马x1

$bmwBuilder = new bmwBuilder();
$bmwBuilder->setSpareParts('Wheel' , '牛逼轮子2号');
$bmwBuilder->setSpareParts('Engine' , '牛逼发动机2号');
$bmwBuilder->getCarModel("宝马s5"); 
$bmwBuilder->getCarModel("宝马s5");  //连续创建两个宝马x1