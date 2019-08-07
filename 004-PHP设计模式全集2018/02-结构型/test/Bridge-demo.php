<?php

abstract class Road{
    public $car;
    public function __construct(Car $car){
        $this->car = $car;
    }
    public abstract function run();
}

class SpeedWay extends Road{
    public function run(){
        echo $this->car->name." run on SpeedWay\n";
    }
}

class Street extends Road{
    public function run(){
        echo $this->car->name." run on Street\n";
    }
}

abstract class Car{
    public $name;
}

class Bus extends Car{
    public function __construct(){
        $this->name = "Bus";
    }
}

class SmallCar extends Car{
    public function __construct(){
        $this->name = "SmallCar";
    }
}

$small_car = new SmallCar();
$SpeedWay = new SpeedWay($small_car);
$SpeedWay->run();

$bus = new Bus();
$Street = new Street($bus);
$Street->run();