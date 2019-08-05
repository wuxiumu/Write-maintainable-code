桥梁模式（Bridge） 

## 2.2.1. 目的

将抽象与实现分离，这样两者可以独立地改变。

## 2.2.2. 例子

[Symfony 学术桥梁](https://github.com/symfony/DoctrineBridge)

## 2.2.3. UML 图

![](/000-imgs/rFOCwQ9yZu.png)

## 2.2.4. 代码

你也可以在 [GitHub](https://github.com/domnikl/DesignPatternsPHP/tree/master/Structural/Bridge) 上查看代码

FormatterInterface.php
```
<?php

namespace DesignPatterns\Structural\Bridge;

/**
* 创建格式化接口。
*/
interface FormatterInterface
{
    public function format(string $text);
}
```

PlainTextFormatter.php
```
<?php

namespace DesignPatterns\Structural\Bridge;

/**
* 创建 PlainTextFormatter 文本格式类实现 FormatterInterface 接口。
*/
class PlainTextFormatter implements FormatterInterface
{

    /**
    * 返回字符串格式。
    */
    public function format(string $text)
    {
        return $text;
    }
}
```

HtmlFormatter.php
```
<?php

namespace DesignPatterns\Structural\Bridge;

/**
* 创建 HtmlFormatter HTML 格式类实现 FormatterInterface 接口。
*/
class HtmlFormatter implements FormatterInterface
{

    /**
    * 返回 HTML 格式。
    */
    public function format(string $text)
    {
        return sprintf('<p>%s</p>', $text);
    }
}
```

Service.php
```
<?php

namespace DesignPatterns\Structural\Bridge;

/**
* 创建抽象类 Service。
*/
abstract class Service
{
    /**
    * @var FormatterInterface
    * 定义实现属性。
    */
    protected $implementation;

    /**
    * @param FormatterInterface $printer
    * 传入 FormatterInterface 实现类对象。
    */
    public function __construct(FormatterInterface $printer)
    {
        $this->implementation = $printer;
    }

    /**
    * @param FormatterInterface $printer
    * 和构造方法的作用相同。
    */
    public function setImplementation(FormatterInterface $printer)
    {
        $this->implementation = $printer;
    }

    /**
    * 创建抽象方法 get() 。
    */
    abstract public function get();
}
```

HelloWorldService.php
```
<?php

namespace DesignPatterns\Structural\Bridge;

/**
* 创建 Service 子类 HelloWorldService 。
*/
class HelloWorldService extends Service
{

    /**
    * 定义抽象方法 get() 。
    * 根据传入的格式类定义来格式化输出 'Hello World' 。
    */
    public function get()
    {
        return $this->implementation->format('Hello World');
    }
}
```

## 2.2.5. 测试

Tests/BridgeTest.php
```
<?php

namespace DesignPatterns\Structural\Bridge\Tests;

use DesignPatterns\Structural\Bridge\HelloWorldService;
use DesignPatterns\Structural\Bridge\HtmlFormatter;
use DesignPatterns\Structural\Bridge\PlainTextFormatter;
use PHPUnit\Framework\TestCase;

/**
* 创建自动化测试单元 BridgeTest 。
*/
class BridgeTest extends TestCase
{

    /**
    * 使用 HelloWorldService 分别测试文本格式实现类和 HTML 格式实
    * 现类。
    */
    public function testCanPrintUsingThePlainTextPrinter()
    {
        $service = new HelloWorldService(new PlainTextFormatter());
        $this->assertEquals('Hello World', $service->get());

        // 现在更改实现方法为使用 HTML 格式器。
        $service->setImplementation(new HtmlFormatter());
        $this->assertEquals('<p>Hello World</p>', $service->get());
    }
}
```
>补充

## 一、桥梁模式结构图
![](/000-imgs/2015127114213605.jpg)

## 二、桥梁模式中主要角色
抽象化(Abstraction)角色：定义抽象类的接口并保存一个对实现化对象的引用。

修正抽象化(Refined Abstraction)角色：扩展抽象化角色，改变和修正父类对抽象化的定义。

实现化(Implementor)角色：定义实现类的接口，不给出具体的实现。此接口不一定和抽象化角色的接口定义相同，实际上，这两个接口可以完全不同。实现化角色应当只给出底层操作，而抽象化角色应当只给出基于底层操作的更高一层的操作。

具体实现化(Concrete Implementor)角色：实现实现化角色接口并定义它的具体实现。

## 三、桥梁模式的优点
### 1、分离接口及其实现部分
将Abstraction与Implementor分享有助于降低对实现部分编译时刻的依赖性
接口与实现分享有助于分层，从而产生更好的结构化系统
### 2、提高可扩充性
### 3、实现细节对客户透明。

## 四、桥梁模式适用场景
1、如果一个系统需要在构件的抽象化和具体化角色之间增加更多的灵活性，避免在两个层次之间建立静态的联系。

2、设计要求实现化角色的任何改变不应当影响客户端，或者说实现化角色的改变对客户端是完全透明的。

3、一个构件有多于一个的抽象化角色和实现化角色，并且系统需要它们之间进行动态的耦合。

4、虽然在系统中使用继承是没有问题的，但是由于抽象化角色和具体化角色需要独立变化，设计要求需要独立管理这两者。

## 五、桥梁模式与其它模式
抽象工厂模式(abstract factory模式)：抽象工厂模式可以用来创建和配置一个特定的桥梁模式。

适配器模式(adapter模式)：适配器模式用来帮助无关的类协同工作。它通常是在系统设计完成之后才会被使用。然而，桥梁模式是在系统开始时就被使用，它使得抽象接口和实现部分可以独立进行改变。

状态模式(state模式)：桥梁模式描述两个等级结构之间的关系，状态模式则是描述一个对象与状态对象之间的关系。状态模式是桥梁模式的一个退化的特殊情况。