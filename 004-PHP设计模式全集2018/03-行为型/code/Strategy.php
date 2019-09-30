<?php
/**
 * 抽象策略角色，以接口实现
 */
interface Strategy {
  
    /**
     * 算法接口
     */
    public function algorithmInterface();
}
  
/**
 * 具体策略角色A
 */
class ConcreteStrategyA implements Strategy {
  
    public function algorithmInterface() {
        echo 'algorithmInterface A'.PHP_EOL;
    }
}
  
/**
 * 具体策略角色B
 */
class ConcreteStrategyB implements Strategy {
  
    public function algorithmInterface() {
        echo 'algorithmInterface B'.PHP_EOL;
    }
}
  
/**
 * 具体策略角色C
 */
class ConcreteStrategyC implements Strategy {
  
    public function algorithmInterface() {
        echo 'algorithmInterface C'.PHP_EOL;
    }
}
  
/**
 * 环境角色
 */
class Context {
    /* 引用的策略 */
    private $_strategy;

    public function __construct(Strategy $strategy) {
        $this->_strategy = $strategy;
    }

    public function contextInterface() {
        $this->_strategy->algorithmInterface();
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
        $strategyA = new ConcreteStrategyA();
        $context = new Context($strategyA);
        $context->contextInterface();

        $strategyB = new ConcreteStrategyB();
        $context = new Context($strategyB);
        $context->contextInterface();

        $strategyC = new ConcreteStrategyC();
        $context = new Context($strategyC);
        $context->contextInterface();
    }
  
}
  
Client::main();