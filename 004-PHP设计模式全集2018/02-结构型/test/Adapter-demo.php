<?php

interface Target{
    public function sampleMethod1();
    public function sampleMethod2();
}

class Adaptee{
    
    public function sampleMethod1(){
        echo 'Adaptee sampleMethod1 <br/>';
    }
}

class Adapter implements Target{

    private $_adaptee;

    public function __construct(Adaptee $adaptee){
        $this->_adaptee = $adaptee;
    }

    public function sampleMethod1(){
        $this->_adaptee->sampleMethod1();
    }

    public function sampleMethod2(){
        echo 'Adapter sampleMethod2 <br/>';
    }
}

class Client{
    
    public static function main(){
        $adaptee = new Adaptee();
        $adapter = new Adapter($adaptee);
        $adapter->sampleMethod1();
        $adapter->sampleMethod2();
    }
}

Client::main();