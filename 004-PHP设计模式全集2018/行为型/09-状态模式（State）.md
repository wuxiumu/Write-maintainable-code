状态模式（State）

## 3.9.1. 目的
状态模式可以基于一个对象的同种事务而封装出不同的行为。

它提供一种简洁的方式使得对象在运行时可以改变自身行为，而不必借助单一庞大的条件判断语句。

## 3.9.2. UML 类图
![](/000-imgs/rkjnhCggA4.png)

## 3.9.3. 代码
你可以在  [GitHub](GitHub) 上找到这些代码

ContextOrder.php
```
<?php

namespace DesignPatterns\Behavioral\State;

class ContextOrder extends StateOrder
{
    public function getState():StateOrder
    {
        return static::$state;
    }

    public function setState(StateOrder $state)
    {
        static::$state = $state;
    }

    public function done()
    {
        static::$state->done();
    }

    public function getStatus(): string
    {
        return static::$state->getStatus();
    }
}
```

StateOrder.php
```
<?php

namespace DesignPatterns\Behavioral\State;

abstract class StateOrder
{
    /**
     * @var array
     */
    private $details;

    /**
     * @var StateOrder $state
     */
    protected static $state;

    /**
     * @return mixed
     */
    abstract protected function done();

    protected function setStatus(string $status)
    {
        $this->details['status'] = $status;
        $this->details['updatedTime'] = time();
    }

    protected function getStatus(): string
    {
        return $this->details['status'];
    }
}
```

ShippingOrder.php
```
<?php

namespace DesignPatterns\Behavioral\State;

class ShippingOrder extends StateOrder
{
    public function __construct()
    {
        $this->setStatus('shipping');
    }

    protected function done()
    {
        $this->setStatus('completed');
    }
}
```

CreateOrder.php
```
<?php

namespace DesignPatterns\Behavioral\State;

class CreateOrder extends StateOrder
{
    public function __construct()
    {
        $this->setStatus('created');
    }

    protected function done()
    {
        static::$state = new ShippingOrder();
    }
}
```

## 3.9.4. 测试
Tests/StateTest.php
```
<?php

namespace DesignPatterns\Behavioral\State\Tests;

use DesignPatterns\Behavioral\State\ContextOrder;
use DesignPatterns\Behavioral\State\CreateOrder;
use PHPUnit\Framework\TestCase;

class StateTest extends TestCase
{
    public function testCanShipCreatedOrder()
    {
        $order = new CreateOrder();
        $contextOrder = new ContextOrder();
        $contextOrder->setState($order);
        $contextOrder->done();

        $this->assertEquals('shipping', $contextOrder->getStatus());
    }

    public function testCanCompleteShippedOrder()
    {
        $order = new CreateOrder();
        $contextOrder = new ContextOrder();
        $contextOrder->setState($order);
        $contextOrder->done();
        $contextOrder->done();

        $this->assertEquals('completed', $contextOrder->getStatus());
    }
}
```
>其他

允许一个对象在其内部状态改变时改变它的行为,对象看起来似乎修改了它所属的类

状态state模式是GOF23种模式中的一种，和命令模式一样，也是一种行为模式。状态模式和命令模式相当像，一样是“接口—实现类”这种模式的应用，是面向接口编程原则的体现。 

状态模式属于对象创建型模式，其意图是允许一个对象在其内部状态改变时改变它的行为，对象看起来似乎修改了他的类。比较常见的例子是在一个表示网络连接的类TCPConnection，一个TCPConnection对象的状态处于若干不同的状态之一:连接已经建立(Established),正在监听，连接已经关闭(closed)。当一个TCPConnection对象收到其他对象的请求时，他根据自身的状态作出不同的反应。 

例如：一个Open请求的结果依赖于该连接已关闭还是连接已建立状态。State模式描述了TCPConnection如何在每一种状态下表现出不同的行为。这一种模式的关键思想是引入了一个称为TCPState的抽象类表示网络的连接状态，TCPState类为各种表示不同的操作状态的字类声明了一个公共接口。TCPState的子类实现与特定的状态相关的行为。例如，TCPEstablished和TCPClosed类分别实现了特定于TCPConnection的连接已建立状态和连接已关闭状态的行为。 

举例来说：一个人具有生气，高兴和抓狂等状态，在这些状态下做同一个事情可能会有不同的结果，一个人的心情可能在这三种状态中循环转变。使用一个moodState类表示一个人的心情，使用mad,Happy,Angry类代表不同的心情。 

## 状态模式的理解，关键有2点： 

1. 通常命令模式的接口中只有一个方法。 而状态模式的接口中有1个或者多个方法。而且，状态模式的实现类的方法，一般返回值；或者是改变实例变量的值。也就是说，状态模式一般和对象的状态有关。实现类的方法有不同的功能，覆盖接口中的方法。状态模式和命令模式一样，也可以用于消除if…else等条件选择语句。 

2. 主要的用途是，作为实例变量，是一个对象引用。命令模式的主要的使用方式是参数回调模式。命令接口作为方法的参数传递进来。然后，在方法体内回调该接口。而状态模式的主要使用方法，是作为实例变量，通过set属性方法，或者构造器把状态接口的具体实现类的实例传递进来。因此，可以这样比较命令模式和状态模式的异同。 

State模式和command模式都是十分常用，粒度比较小的模式，是很多更大型模式的一部分。基本上，state模式和command模式是十分相似的。只要开发者心中对单例和多例有一个清醒的认识，即使不把它们分为两种模式也没事。