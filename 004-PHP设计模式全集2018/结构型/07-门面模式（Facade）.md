门面模式（Facade）

## 2.7.1. 目的
门面模式的最初目的并不是为了避免让你阅读复杂的 API 文档，这只是一个附带作用。其实它的本意是为了降低耦合性并且遵循 Demeter 定律。

一个门面旨在通过嵌入许多（但有时只有一个）接口来分离客户端和子系统。当然，也是为了降低复杂度。

门面不会禁止你访问子系统。

你可以（应该）有多个门面对应一个子系统。

这就是为什么一个好的门面里没有 new 的原因。如果每个方法都有多种创建，那并不是一个门面，而是一个构建器 [抽象的 | 静态的 | 简单的] 或是一个工厂 [方法] 。

最好的门面是没有 new 的，并且其构造函数带有接口类型提示的参数。 如果你需要创建新的实例，可以使用工厂作为变量。

## 2.7.2. UML 图
![z5RZ820Gdy.png](/000-imgs/z5RZ820Gdy.png)

## 2.7.3. 代码
你也可以在 [GitHub]() 上查看此代码

Facade.php
```
<?php

namespace DesignPatterns\Structural\Facade;

class Facade
{
    /**
    * @var OsInterface
    * 定义操作系统接口变量。
    */
    private $os;

    /**
    * @var BiosInterface
    * 定义基础输入输出系统接口变量。
    */
    private $bios;

    /**
    * @param BiosInterface $bios
    * @param OsInterface $os
    * 传入基础输入输出系统接口对象 $bios 。
    * 传入操作系统接口对象 $os 。
    */
    public function __construct(BiosInterface $bios, OsInterface $os)
    {
        $this->bios = $bios;
        $this->os = $os;
    }

    /**
    * 构建基础输入输出系统执行启动方法。
    */
    public function turnOn()
    {
        $this->bios->execute();
        $this->bios->waitForKeyPress();
        $this->bios->launch($this->os);
    }

    /**
    * 构建系统关闭方法。
    */
    public function turnOff()
    {
        $this->os->halt();
        $this->bios->powerDown();
    }
}
```

OsInterface.php
```
<?php

namespace DesignPatterns\Structural\Facade;

/**
* 创建操作系统接口类 OsInterface 。
*/
interface OsInterface
{
    /**
    * 声明关机方法。
    */
    public function halt();

    /** 
    * 声明获取名称方法，返回字符串格式数据。
    */
    public function getName(): string;
}
```

BiosInterface.php
```
<?php

namespace DesignPatterns\Structural\Facade;

/**
* 创建基础输入输出系统接口类 BiosInterface 。
*/
interface  BiosInterface
{
    /**
    * 声明执行方法。
    */
    public function execute();

    /**
    * 声明等待密码输入方法
    */
    public function waitForKeyPress();

    /**
    * 声明登录方法。
    */
    public function launch(OsInterface $os);

    /**
    * 声明关机方法。
    */
    public function powerDown();
}
```

## 2.7.4. 测试
Tests/FacadeTest.php
```
<?php

namespace DesignPatterns\Structural\Facade\Tests;

use DesignPatterns\Structural\Facade\Facade;
use DesignPatterns\Structural\Facade\OsInterface;
use PHPUnit\Framework\TestCase;

/**
* 创建自动化测试单元 FacadeTest 。
*/
class FacadeTest extends TestCase
{
    public function testComputerOn()
    {
        /** @var OsInterface|\PHPUnit_Framework_MockObject_MockObject $os */
        $os = $this->createMock('DesignPatterns\Structural\Facade\OsInterface');

        $os->method('getName')
            ->will($this->returnValue('Linux'));

        $bios = $this->getMockBuilder('DesignPatterns\Structural\Facade\BiosInterface')
            ->setMethods(['launch', 'execute', 'waitForKeyPress'])
            ->disableAutoload()
            ->getMock();

        $bios->expects($this->once())
            ->method('launch')
            ->with($os);

        $facade = new Facade($bios, $os);

        // 门面接口很简单。
        $facade->turnOn();

        // 但你也可以访问底层组件。
        $this->assertEquals('Linux', $os->getName());
    }
}
```

>其他

## 一、意图
为子系统中的一组接口提供一个一致的界面，Facade模式定义了一个高层次的接口，使得子系统更加容易使用【GOF95】
外部与子系统的通信是通过一个门面(Facade)对象进行。

## 二、门面模式结构图

![2015127115558714.jpg](/000-imgs/2015127115558714.jpg)


## 三、门面模式中主要角色
### 门面(Facade)角色：

此角色将被客户端调用

知道哪些子系统负责处理请求

将用户的请求指派给适当的子系统

### 子系统(subsystem)角色：

实现子系统的功能

处理由Facade对象指派的任务

没有Facade的相关信息，可以被客户端直接调用

可以同时有一个或多个子系统，每个子系统都不是一个单独的类，而一个类的集合。每个子系统都可以被客户端直接调用，或者被门面角色调用。子系统并知道门面模式的存在，对于子系统而言，门面仅仅是另一个客户端。

## 四、门面模式的优点
1、它对客户屏蔽了子系统组件，因而减少了客户处理的对象的数目并使得子系统使用起来更加方便

2、实现了子系统与客户之间的松耦合关系

3、如果应用需要，它并不限制它们使用子系统类。因此可以在系统易用性与能用性之间加以选择

## 五、门面模式适用场景
1、为一些复杂的子系统提供一组接口

2、提高子系统的独立性

3、在层次化结构中，可以使用门面模式定义系统的每一层的接口

## 六、门面模式与其它模式

抽象工厂模式(abstract factory模式)：Abstract Factory模式可以与Facade模式一起使用以提供一个接口，这一接口可用来以一种子系统独立的方式创建子系统对象。Abstract Factory模式也可以代替Facade模式隐藏那些与平台相关的类

调停者模式：Mediator模式与Facade模式的相似之处是，它抽象了一些已有类的功能。然而，Mediator目的是对同事之间的任意通讯进行抽象，通常集中不属于任何单个对象的功能。Mediator的同事对象知道中介者并与它通信，而不是直接与其他同类对象通信。相对而言，Facade模式仅对子系统对象的接口进行抽象，从而使它们更容易使用；它并定义不功能，子系统也不知道facade的存在

单例模式(singleton模式)：一般来说，仅需要一个Facade对象，因此Facade对象通常属于Singleton对象。
