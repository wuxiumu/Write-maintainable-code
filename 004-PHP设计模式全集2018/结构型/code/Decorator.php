<?php
/**
 * 抽象构件角色
 */
interface Component {
    /**
     * 示例方法
     */
    public function operation();
}
  
/**
 * 装饰角色
 */
abstract class Decorator implements Component{
  
    protected $_component;

    public function __construct(Component $component) {
        $this->_component = $component;
    }

    public function operation() {
        $this->_component->operation();
    }
}
  
/**
 * 具体装饰类A
 */
class ConcreteDecoratorA extends Decorator {
    public function __construct(Component $component) {
        
        parent::__construct($component);

    }

    public function operation() {
        parent::operation(); // 调用装饰类的操作
        $this->addedOperationA(); // 新增加的操作
    }

    /**
     * 新增加的操作A，即装饰上的功能
     */
    public function addedOperationA() {
        echo 'Add Operation A <br />';
    }
}
  
/**
 * 具体装饰类B
 */
class ConcreteDecoratorB extends Decorator {
    public function __construct(Component $component) {
        
        parent::__construct($component);

    }

    public function operation() {
        parent::operation();
        $this->addedOperationB();
    }

    /**
     * 新增加的操作B，即装饰上的功能
     */
    public function addedOperationB() {
        echo 'Add Operation B <br />';
    }
}
  
/**
 * 具体构件
 */
class ConcreteComponent implements Component{
  
    public function operation() {
        echo 'Concrete Component operation <br />';
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
        $component = new ConcreteComponent();
        $decoratorA = new ConcreteDecoratorA($component);
        $decoratorB = new ConcreteDecoratorB($decoratorA);

        $decoratorA->operation();
        $decoratorB->operation();
    }
  
}
  
Client::main();
?>