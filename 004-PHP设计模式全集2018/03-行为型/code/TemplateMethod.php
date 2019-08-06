<?php
//抽象模板(AbstractClass)角色
abstract class AbstractClass
{
    public abstract function PrimitiveOperation1();
    public abstract function PrimitiveOperation2();
    public function method(){
        $this->PrimitiveOperation1();
        $this->PrimitiveOperation2();
        var_dump('method');
    }
}

//具体模板(ConcrteClass)角色
class ConcreteClassA extends AbstractClass
{
    public function PrimitiveOperation1()
    {
        var_dump('类A方法1实现');
    }
    public function PrimitiveOperation2()
    {
        var_dump('类A方法2实现');
    }
}
class ConcreteClassB extends AbstractClass
{
    public function PrimitiveOperation1()
    {
        var_dump('类B方法1实现');
    }
    public function PrimitiveOperation2()
    {
        var_dump('类B方法2实现');
    }
}

$a=new ConcreteClassA();
$a->method();

$b=new ConcreteClassB();
$b->method();