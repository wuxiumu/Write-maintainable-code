<?php

interface Facade{
    public function turnOn();
    public function turnOff();
}

class PcLight{
    public function turnOn(){}
    public function turnOff(){
        echo "turn off PcLight <br/>";
    }
}

class Pcmachine{
    public function turnOn(){}
    public function turnOff(){
        echo "turn off Pcmachine <br/>";
    }
}

class Power{
    public function turnOn(){}
    public function turnOff(){
        echo "turn off Power <br/>";
    }    
}

class PcFacade implements Facade{
    
    private $PcLight;
    private $Pcmachine;
    private $Power;

    public function __construct(){
         $this->PcLight = new PcLight();
         $this->Pcmachine = new Pcmachine();
         $this->Power = new Power();
    }
    public function turnOff() { 
          $this->PcLight ->turnOff();
          $this->Pcmachine ->turnOff();
          $this->Power ->turnOff();
     }
    public function turnOn(){}
}

$button = new PcFacade();
$button->turnOff();