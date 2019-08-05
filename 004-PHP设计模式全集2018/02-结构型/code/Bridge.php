<?php
/**
 * 抽象化角色
 * 抽象化给出的定义，并保存一个对实现化对象的引用。
 */
abstract class Abstraction {
  
    /* 对实现化对象的引用 */
    protected $imp;

    /**
     * 某操作方法
     */
    public function operation() {
        $this->imp->operationImp();
    }
}
  
/**
 * 修正抽象化角色
 * 扩展抽象化角色，改变和修正父类对抽象化的定义。
 */
class RefinedAbstraction extends Abstraction {
  
    public function __construct(Implementor $imp) {
        $this->imp = $imp;
    }

    /**
     * 操作方法在修正抽象化角色中的实现
     */
    public function operation() {
        echo 'RefinedAbstraction operation ';
        $this->imp->operationImp();
    }
}
  
/**
 * 实现化角色
 * 给出实现化角色的接口，但不给出具体的实现。
 */
abstract class Implementor {
  
    /**
     * 操作方法的实现化声明
     */
    abstract public function operationImp();
}
  
/**
 * 具体化角色A
 * 给出实现化角色接口的具体实现
 */
class ConcreteImplementorA extends Implementor {
  
    /**
     * 操作方法的实现化实现
     */
    public function operationImp() {
        echo 'Concrete implementor A operation <br />';
    }
}
  
/**
 * 具体化角色B
 * 给出实现化角色接口的具体实现
 */
class ConcreteImplementorB extends Implementor {
  
    /**
     * 操作方法的实现化实现
     */
    public function operationImp() {
        echo 'Concrete implementor B operation <br />';
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
        $abstraction = new RefinedAbstraction(new ConcreteImplementorA());
        $abstraction->operation();

        $abstraction = new RefinedAbstraction(new ConcreteImplementorB());
        $abstraction->operation();
    }
}
  
Client::main();
?>