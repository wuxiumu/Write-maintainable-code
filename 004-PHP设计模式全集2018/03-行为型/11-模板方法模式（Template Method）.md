模板方法模式（Template Method）

## 3.11.1. Purpose
模板方法模式是一种行为型的设计模式。

可能你已经见过这种模式很多次了。它是一种让抽象模板的子类「完成」一系列算法的行为策略。

众所周知的「好莱坞原则」：「不要打电话给我们，我们会打电话给你」。这个类不是由子类调用的，而是以相反的方式。怎么做？当然很抽象啦！

换而言之，它是一种非常适合框架库的算法骨架。用户只需要实现子类的一种方法，其父类便可去搞定这项工作了。

这是一种分离具体类的简单办法，且可以减少复制粘贴，这也是它常见的原因。

## 3.11.2. UML 类图
![](/000-imgs/5Brm3Ch0jM.png)

## 3.11.3. 代码
你可以在 [GitHub](https://github.com/domnikl/DesignPatternsPHP/tree/master/Behavioral/TemplateMethod) 上找到这些代码

Journey.php
```
<?php

namespace DesignPatterns\Behavioral\TemplateMethod;

abstract class Journey
{
    /**
     * @var string[]
     */
    private $thingsToDo = [];

    /**
     * 这是当前类及其子类提供的公共服务
     * 注意，它「冻结」了全局的算法行为
     * 如果你想重写这个契约，只需要实现一个包含 takeATrip() 方法的接口
     */
    final public function takeATrip()
    {
        $this->thingsToDo[] = $this->buyAFlight();
        $this->thingsToDo[] = $this->takePlane();
        $this->thingsToDo[] = $this->enjoyVacation();
        $buyGift = $this->buyGift();

        if ($buyGift !== null) {
            $this->thingsToDo[] = $buyGift;
        }

        $this->thingsToDo[] = $this->takePlane();
    }

    /**
     * 这个方法必须要实现，它是这个模式的关键点
     */
    abstract protected function enjoyVacation(): string;

    /**
     * 这个方法是可选的，也可能作为算法的一部分
     * 如果需要的话你可以重写它
     *
     * @return null|string
     */
    protected function buyGift()
    {
        return null;
    }

    private function buyAFlight(): string
    {
        return 'Buy a flight ticket';
    }

    private function takePlane(): string
    {
        return 'Taking the plane';
    }

    /**
     * @return string[]
     */
    public function getThingsToDo(): array
    {
        return $this->thingsToDo;
    }
}
```

BeachJourney.php
```
<?php

namespace DesignPatterns\Behavioral\TemplateMethod;

class BeachJourney extends Journey
{
    protected function enjoyVacation(): string
    {
        return "Swimming and sun-bathing";
    }
}
```

CityJourney.php
```
<?php

namespace DesignPatterns\Behavioral\TemplateMethod;

class CityJourney extends Journey
{
    protected function enjoyVacation(): string
    {
        return "Eat, drink, take photos and sleep";
    }

    protected function buyGift(): string
    {
        return "Buy a gift";
    }
}
```

### 3.11.4. Test
Tests/JourneyTest.php
```
<?php

namespace DesignPatterns\Behavioral\TemplateMethod\Tests;

use DesignPatterns\Behavioral\TemplateMethod;
use PHPUnit\Framework\TestCase;

class JourneyTest extends TestCase
{
    public function testCanGetOnVacationOnTheBeach()
    {
        $beachJourney = new TemplateMethod\BeachJourney();
        $beachJourney->takeATrip();

        $this->assertEquals(
            ['Buy a flight ticket', 'Taking the plane', 'Swimming and sun-bathing', 'Taking the plane'],
            $beachJourney->getThingsToDo()
        );
    }

    public function testCanGetOnAJourneyToACity()
    {
        $cityJourney = new TemplateMethod\CityJourney();
        $cityJourney->takeATrip();

        $this->assertEquals(
            [
                'Buy a flight ticket',
                'Taking the plane',
                'Eat, drink, take photos and sleep',
                'Buy a gift',
                'Taking the plane'
            ],
            $cityJourney->getThingsToDo()
        );
    }
}
```
>其他

## 什么是模板方法模式

模板方法(Template Method)设计模式中使用了一个类方法templateMethod(), 该方法是抽象类中的一个具体方法, 这个方法的作用是对抽象方法序列排序,具体实现留给具体类来完成.关键在于模板方法模式定义了操作中算法的"骨架",而由具体类来实现.

## 什么时候使用模板方法

如果已经明确算法中的一些步骤, 不过这些步骤可以采用多种不同的方法实现, 就可以使用模板方法调试.如果算法中的步骤不变, 可以把这些步骤留给子类具体实现.在这种情况下, 可以使用模板方法设计模式来组织抽象类中的基本操作(函数/方法).然后由子类来实现应用所需的这些操作.

还有一种用法稍微复杂一些, 可能需要把子类共同的行为放在一个类中, 以避免代码重复.

如果使用多个类来解决同一个大型问题, 可能很快就会出现重复代码.

还有一点,可以使用模板方法模式控制子类扩展,也就是所谓的"钩子".

## 示例

在PHP编程中,可能经常会遇到一个问题: 要建立带图题的图像. 这个算法相当简单, 就是显示图像, 然后的图像下面显示文本.

由于模板设计中只涉及两个参与者, 所以这是最容易理解的模式之一, 同时也非常有用. 抽象建立templateMethod(),并由具体类实现这个方法.

### 抽象类

抽象类是这里的关键, 因为它同时包含具体和抽象方法. 模板方法往往是具体方法, 其操作是抽象的

两个抽象方法分别是addPicture和addTitile,这两个操作都包含一个参数, 分别表示图像的URL信息和图像标题.

Template.php
```
<?php
abstract class Template
{
  protected $picture;
  protected $title;
  public function display($pictureNow, $titleNow)
  {
    $this->picture = $pictureNow;
    $this->title = $titleNow;
    $this->addPicture($this->picture);
    $this->addTitle($this->title);
  }
  abstract protected function addPicture($picture);
  abstract protected function addTitle($title);
}
```

### 具体类

Concrete.php
```
<?php
include_once('Template.php');
class Concrete extends Template
{
  protected function addPicture($picture)
  {
    $this->picture = 'picture/' . $picture;
    echo "图像路径为:" . $this->picture . '<br />';
  }
  protected function addTitle($title)
  {
    $this->title = $title;
    echo "<em>标题: </em>" . $this->title . "<br />";
  }
}
```
### 客户

Client.php
``` 
<?php
function __autoload($class_name)
{
  include $class_name . '.php';
}
class Client
{
  public function __construct()
  {
    $title = "chenqionghe is a handsome boy";
    $concrete = new Concrete();
    $concrete->display('chenqionghe.png', $title);
  }
}
$worker = new Client();
```
$concrete变量实例化了Concrete, 但是它调用了display模板方法, 这是从父类继承的具体操作, 父类通过display()调用子类的操作.

### 运行后输出
```
图像路径为:picture/chenqionghe.png
标题: chenqionghe is a handsome boy
```

可以看到,客户只需要提供图像地址和标题

模板方法设计模式中的钩子

有时模板方法函数可能有一个你不想要的步骤, 某些特定情况下你可能不希望执行这个步骤, 这时候就可以用到模板方法的钩子.

在模板方法设计模式中, 利用钩子可以将一个方法作为模板的一部分,不过不一定会用到这个方法, 换句话说, 它是方法的一部分,不过它包含一个钩子, 可以处理例外情况. 子类可以为算法增加一个可选元素, 这样一来, 尽管仍按模板方法建立的顺序执行, 但有可能并不完成模板方法期望的动作. 对于这种可选的情况, 钩子就是解决这个问题最理想的工具.

### 示例

去网购商品, 登场8折, 如果总商品费用超过200元, 就免去12.95元钱运费.

### 建立钩子

在模板方法中建立钩子方法很有意思, 尽管子类可以改变钩子的行为, 但仍然要遵循模板中定义的顺序

IHook.php
```
<?php
abstract class IHook
{
  protected $hook;
  protected $fullCost;
  public function templateMethod($fullCost, $hook)
  {
    $this->fullCost = $fullCost;
    $this->hook = $hook;
    $this->addGoods();
    $this->addShippingHook();
    $this->displayCost();
  }
  protected abstract function addGoods();
  protected abstract function addShippingHook();
  protected abstract function displayCost();
}
```

这里有3个抽象方法: addGoods(), addShippingHook(),displayCost(), 抽象类IHook实现的templateMethod()中确定了它们的顺序. 在这里, 钩子方法放在中间, 实际上模板方法指定的顺序中, 钩子可以放在任意位置. 模板方法需要两个参数, 一个是总花费, 另外还需要一个变量用来确定顾客是否免收运费.

### 实现钩子

一旦抽象类中建立了这些抽象方法, 并指定了它们执行的顺序, 子类将实现所有这3个方法:

Concrete.php
```
<?php
class Concrete extends IHook
{
  protected function addGoods()
  {
    $this->fullCost = $this->fullCost * 0.8;
  }
  protected function addShippingHook()
  {
    if(!$this->hook)
    {
      $this->fullCost += 12.95;
    }
  }
  protected function displayCost()
  {
    echo "您需要支付: " . $this->fullCost . '元<br />';
  }
}
```
addGoods和displayCost都是标准方法, 只有一个实现., 不过, addShippingHook的实现有所不同, 其中有一个条件来确定是否增加运费. 这就是钩子.

### 客户Client

Client.php
```
<?php
function __autoload($class_name)
{
  include $class_name . '.php';
}
class Client
{
  private $totalCost;
  private $hook;
  public function __construct($goodsTotal)
  {
    $this->totalCost = $goodsTotal;
    $this->hook = $this->totalCost >= 200;
    $concrete = new Concrete();
    $concrete->templateMethod($this->totalCost, $this->hook);
  }
}
$worker = new Client(100);
$worker = new Client(200);
```
该Client演示了分别购买100块钱和200块钱的商品最后的费用,运行结果如下
```
您需要支付: 92.95元
您需要支付: 160元
```