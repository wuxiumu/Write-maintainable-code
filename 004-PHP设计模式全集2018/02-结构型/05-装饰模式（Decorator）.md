装饰模式（Decorator）

## 2.5.1. 目的
为类实例动态增加新的方法。

## 2.5.2. 例子
Zend Framework: Zend_Form_Element 实例的装饰者
Web Service Layer: 用于 REST 服务的 JSON 和 XML 装饰者 (当然，在这个例子中理应只有一个是被允许的)

## 2.5.3. UML 图
![WHNWAjWM3i.png](/000-imgs/HsGmgG5UIm.png)

## 2.5.4. Code
你也可以在 [GitHub](https://github.com/domnikl/DesignPatternsPHP/tree/master/Structural/Decorator) 上查看代码

RenderableInterface.php
```
<?php

namespace DesignPatterns\Structural\Decorator;

/**
* 创建渲染接口。
* 这里的装饰方法 renderData() 返回的是字符串格式数据。
*/
interface RenderableInterface
{
    public function renderData(): string;
}
```

Webservice.php
```
<?php

namespace DesignPatterns\Structural\Decorator;

/**
* 创建 Webservice 服务类实现 RenderableInterface。
* 该类将在后面为装饰者实现数据的输入。
*/
class Webservice implements RenderableInterface
{
    /**
    * @var string
    */
    private $data;

    /**
    * 传入字符串格式数据。
    */
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
    * 实现 RenderableInterface 渲染接口中的 renderData() 方法。
    * 返回传入的数据。
    */
    public function renderData(): string
    {
        return $this->data;
    }
}
```

RendererDecorator.php
```
<?php

namespace DesignPatterns\Structural\Decorator;

 /**
 * 装饰者必须实现渲染接口类 RenderableInterface 契约，这是该设计
 * 模式的关键点。否则，这将不是一个装饰者而只是一个自欺欺人的包
 * 装。
 * 
 * 创建抽象类 RendererDecorator （渲染器装饰者）实现渲染接口。
 */
abstract class RendererDecorator implements RenderableInterface
{
    /**
     * @var RenderableInterface
     * 定义渲染接口变量。
     */
    protected $wrapped;

    /**
     * @param RenderableInterface $renderer
     * 传入渲染接口类对象 $renderer。
     */
    public function __construct(RenderableInterface $renderer)
    {
        $this->wrapped = $renderer;
    }
}
```

XmlRenderer.php
```
<?php

namespace DesignPatterns\Structural\Decorator;

/**
* 创建 Xml 修饰者并继承抽象类 RendererDecorator 。
*/
class XmlRenderer extends RendererDecorator
{

    /**
    * 对传入的渲染接口对象进行处理，生成 DOM 数据文件。
    */
    public function renderData(): string
    {
        $doc = new \DOMDocument();
        $data = $this->wrapped->renderData();
        $doc->appendChild($doc->createElement('content', $data));

        return $doc->saveXML();
    }
}
```

JsonRenderer.php
```
<?php

namespace DesignPatterns\Structural\Decorator;

/**
* 创建 Json 修饰者并继承抽象类 RendererDecorator 。
*/
class JsonRenderer extends RendererDecorator
{
    /**
    * 对传入的渲染接口对象进行处理，生成 JSON 数据。
    */
    public function renderData(): string
    {
        return json_encode($this->wrapped->renderData());
    }
}
```

## 2.5.5. 测试
Tests/DecoratorTest.php
```
<?php

namespace DesignPatterns\Structural\Decorator\Tests;

use DesignPatterns\Structural\Decorator;
use PHPUnit\Framework\TestCase;

/**
* 创建自动化测试单元 DecoratorTest 。
*/
class DecoratorTest extends TestCase
{
    /**
     * @var Decorator\Webservice
     */
    private $service;

    /** 
    * 传入字符串 'foobar' 。
    */
    protected function setUp()
    {
        $this->service = new Decorator\Webservice('foobar');
    }

    /**
    * 测试 JSON 装饰者。
    * 这里的 assertEquals 是为了判断返回的结果是否符合预期。
    */
    public function testJsonDecorator()
    {
        $service = new Decorator\JsonRenderer($this->service);

        $this->assertEquals('"foobar"', $service->renderData());
    }

    /**
    * 测试 Xml 装饰者。
    */
    public function testXmlDecorator()
    {
        $service = new Decorator\XmlRenderer($this->service);

        $this->assertXmlStringEqualsXmlString('<?xml version="1.0"?><content>foobar</content>', $service->renderData());
    }
}
```
>其他

动态的给一个对象添加一些额外的职责。就增加功能来说，Decorator模式相比生成子类更为灵活【GOF95】
装饰模式是以对客户透明的方式动态地给一个对象附加上更多的职责。

这也就是说，客户端并不会觉得对象在装饰前和装饰后有什么不同。

装饰模式可以在不使用创造更多子类的情况下，将对象的功能加以扩展。

## 一、装饰模式结构图
![WHNWAjWM3i.png](/000-imgs/2015127113024810.jpg)
 

## 二、装饰模式中主要角色
抽象构件(Component)角色：定义一个对象接口，以规范准备接收附加职责的对象，从而可以给这些对象动态地添加职责。

具体构件(Concrete Component)角色：定义一个将要接收附加职责的类。

装饰(Decorator)角色：持有一个指向Component对象的指针，并定义一个与Component接口一致的接口。

具体装饰(Concrete Decorator)角色：负责给构件对象增加附加的职责。

## 三、装饰模式的优缺点
### 装饰模式的优点：
1、比静态继承更灵活；

2、避免在层次结构高层的类有太多的特征

### 装饰模式的缺点：
1、使用装饰模式会产生比使用继承关系更多的对象。并且这些对象看上去都很想像，从而使得查错变得困难。

## 四、装饰模式适用场景
1、在不影响其他对象的情况下，以动态、透明的方式给单个对象添加职责。

2、处理那些可以撤消的职责，即需要动态的给一个对象添加功能并且这些功能是可以动态的撤消的。

3、当不能彩生成子类的方法进行扩充时。一种情况是，可能有大量独立的扩展，为支持每一种组合将产生大量的子类，使得子类数目呈爆炸性增长。另一种情况可能是因为类定义被隐藏，或类定义不能用于生成子类。
