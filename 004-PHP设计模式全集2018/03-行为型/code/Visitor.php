<?php
  
interface Visitor {
    public function visitConcreteElementA(ConcreteElementA $elementA);
    public function visitConcreteElementB(concreteElementB $elementB);
}
  
interface Element {
    public function accept(Visitor $visitor);
}
  
/**
 * 具体的访问者1
 */
class ConcreteVisitor1 implements Visitor {
    public function visitConcreteElementA(ConcreteElementA $elementA) {
        echo $elementA->getName() . " visitd by ConcerteVisitor1 <br />";
    }

    public function visitConcreteElementB(ConcreteElementB $elementB) {
        echo $elementB->getName() . " visited by ConcerteVisitor1 <br />";
    }
  
}
  
/**
 * 具体的访问者2
 */
class ConcreteVisitor2 implements Visitor {
    public function visitConcreteElementA(ConcreteElementA $elementA) {
        echo $elementA->getName() . " visitd by ConcerteVisitor2 <br />";
    }

    public function visitConcreteElementB(ConcreteElementB $elementB) {
        echo $elementB->getName() . " visited by ConcerteVisitor2 <br />";
    }
  
}
  
/**
 * 具体元素A
 */
class ConcreteElementA implements Element {
    private $_name;

    public function __construct($name) {
        $this->_name = $name;
    }

    public function getName() {
        return $this->_name;
    }

    /**
     * 接受访问者调用它针对该元素的新方法
     * @param Visitor $visitor
     */
    public function accept(Visitor $visitor) {
        $visitor->visitConcreteElementA($this);
    }
  
}
  
/**
 * 具体元素B
 */
class ConcreteElementB implements Element {
    private $_name;

    public function __construct($name) {
        $this->_name = $name;
    }

    public function getName() {
        return $this->_name;
    }

    /**
     * 接受访问者调用它针对该元素的新方法
     * @param Visitor $visitor
     */
    public function accept(Visitor $visitor) {
        $visitor->visitConcreteElementB($this);
    }
  
}
  
/**
 * 对象结构 即元素的集合
 */
class ObjectStructure {
    private $_collection;

    public function __construct() {
        $this->_collection = array();
    }


    public function attach(Element $element) {
        return array_push($this->_collection, $element);
    }

    public function detach(Element $element) {
        $index = array_search($element, $this->_collection);
        if ($index !== FALSE) {
            unset($this->_collection[$index]);
        }

        return $index;
    }

    public function accept(Visitor $visitor) {
        foreach ($this->_collection as $element) {
            $element->accept($visitor);
        }
    }
}
  
class Client {
  
    /**
     * Main program.
     */
    public static function main() {
        $elementA = new ConcreteElementA("ElementA");
        $elementB = new ConcreteElementB("ElementB");
        $elementA2 = new ConcreteElementB("ElementA2");
        $visitor1 = new ConcreteVisitor1();
        $visitor2 = new ConcreteVisitor2();

        $os = new ObjectStructure();
        $os->attach($elementA);
        $os->attach($elementB);
        $os->attach($elementA2);
        $os->detach($elementA);
        $os->accept($visitor1);
        $os->accept($visitor2);
    }
  
}
  
Client::main();