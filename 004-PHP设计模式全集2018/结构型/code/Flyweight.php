<?php
/**
 * 抽象享元角色
 */
abstract class Flyweight {
  
    /**
     * 示意性方法
     * @param string $state 外部状态
     */
    abstract public function operation($state);
}
  
/**
 * 具体享元角色
 */
class ConcreteFlyweight extends Flyweight {
  
    private $_intrinsicState = null;

    /**
     * 构造方法
     * @param string $state 内部状态
     */
    public function __construct($state) {
        $this->_intrinsicState = $state;
    }

    public function operation($state) {
        echo 'ConcreteFlyweight operation, Intrinsic State = ' . $this->_intrinsicState
        . ' Extrinsic State = ' . $state . '<br />';
    }
  
}
  
/**
 * 不共享的具体享元，客户端直接调用
 */
class UnsharedConcreteFlyweight extends Flyweight {
  
    private $_intrinsicState = null;

    /**
     * 构造方法
     * @param string $state 内部状态
     */
    public function __construct($state) {
        $this->_intrinsicState = $state;
    }

    public function operation($state) {
        echo 'UnsharedConcreteFlyweight operation, Intrinsic State = ' . $this->_intrinsicState
        . ' Extrinsic State = ' . $state . '<br />';
    }
  
}
  
/**
 * 享元工厂角色
 */
class FlyweightFactory {
  
    private $_flyweights;
    
    public function __construct() {
        $this->_flyweights = array();
    }
    
    public function getFlyweigth($state) {
        if (isset($this->_flyweights[$state])) {
            return $this->_flyweights[$state];
        } else {
            return $this->_flyweights[$state] = new ConcreteFlyweight($state);
        }
    }
  
}
  
/**
 * 客户端
 */
class Client {
  
    /**
     * Main program.
     */
    public static function main() {
        $flyweightFactory = new FlyweightFactory();
        $flyweight = $flyweightFactory->getFlyweigth('state A');
        $flyweight->operation('other state A');

        $flyweight = $flyweightFactory->getFlyweigth('state B');
        $flyweight->operation('other state B');

        /* 不共享的对象，单独调用 */
        $uflyweight = new UnsharedConcreteFlyweight('state A');
        $uflyweight->operation('other state A');
    }

}
  
Client::main();
?>