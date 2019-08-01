 策略模式（Strategy）

## 3.10.1. 术语：
上下文

策略

具体策略

## 3.10.2. 目的
分离「策略」并使他们之间能互相快速切换。此外，这种模式是一种不错的继承替代方案（替代使用扩展抽象类的方式）。

## 3.10.3. 例子
对一个对象列表进行排序，一种按照日期，一种按照 id

简化版的的单元测试：例如，在使用文件存储和内存存储之间互相切换

## 3.10.4. UML 类图
![](/000-imgs/ZALJKc6DB2.png)

## 3.10.5. 代码
你可以在 [GitHub](https://github.com/domnikl/DesignPatternsPHP/tree/master/Behavioral/Strategy) 上找到这个代码。

Context.php
```
<?php

namespace DesignPatterns\Behavioral\Strategy;

class Context
{
    /**
     * @var ComparatorInterface
     */
    private $comparator;

    public function __construct(ComparatorInterface $comparator)
    {
        $this->comparator = $comparator;
    }

    public function executeStrategy(array $elements) : array
    {
        uasort($elements, [$this->comparator, 'compare']);

        return $elements;
    }
}
```

ComparatorInterface.php
```
<?php

namespace DesignPatterns\Behavioral\Strategy;

interface ComparatorInterface
{
    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return int
     */
    public function compare($a, $b): int;
}
```

DateComparator.php
```
<?php

namespace DesignPatterns\Behavioral\Strategy;

class DateComparator implements ComparatorInterface
{
    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return int
     */
    public function compare($a, $b): int
    {
        $aDate = new \DateTime($a['date']);
        $bDate = new \DateTime($b['date']);

        return $aDate <=> $bDate;
    }
}
```

IdComparator.php
```
<?php

namespace DesignPatterns\Behavioral\Strategy;

class IdComparator implements ComparatorInterface
{
    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return int
     */
    public function compare($a, $b): int
    {
        return $a['id'] <=> $b['id'];
    }
}
```

## 3.10.6. 测试
Tests/StrategyTest.php
```
<?php

namespace DesignPatterns\Behavioral\Strategy\Tests;

use DesignPatterns\Behavioral\Strategy\Context;
use DesignPatterns\Behavioral\Strategy\DateComparator;
use DesignPatterns\Behavioral\Strategy\IdComparator;
use PHPUnit\Framework\TestCase;

class StrategyTest extends TestCase
{
    public function provideIntegers()
    {
        return [
            [
                [['id' => 2], ['id' => 1], ['id' => 3]],
                ['id' => 1],
            ],
            [
                [['id' => 3], ['id' => 2], ['id' => 1]],
                ['id' => 1],
            ],
        ];
    }

    public function provideDates()
    {
        return [
            [
                [['date' => '2014-03-03'], ['date' => '2015-03-02'], ['date' => '2013-03-01']],
                ['date' => '2013-03-01'],
            ],
            [
                [['date' => '2014-02-03'], ['date' => '2013-02-01'], ['date' => '2015-02-02']],
                ['date' => '2013-02-01'],
            ],
        ];
    }

    /**
     * @dataProvider provideIntegers
     *
     * @param array $collection
     * @param array $expected
     */
    public function testIdComparator($collection, $expected)
    {
        $obj = new Context(new IdComparator());
        $elements = $obj->executeStrategy($collection);

        $firstElement = array_shift($elements);
        $this->assertEquals($expected, $firstElement);
    }

    /**
     * @dataProvider provideDates
     *
     * @param array $collection
     * @param array $expected
     */
    public function testDateComparator($collection, $expected)
    {
        $obj = new Context(new DateComparator());
        $elements = $obj->executeStrategy($collection);

        $firstElement = array_shift($elements);
        $this->assertEquals($expected, $firstElement);
    }
}
```

> 其他
## 一、意图
定义一系列的算法，把它们一个个封装起来，并且使它们可相互替换。策略模式可以使算法可独立于使用它的客户而变化
策略模式变化的是算法

## 二、策略模式结构图
![](/000-imgs/2015127163141064.jpg)

## 三、策略模式中主要角色
抽象策略(Strategy）角色：定义所有支持的算法的公共接口。通常是以一个接口或抽象来实现。Context使用这个接口来调用其ConcreteStrategy定义的算法

具体策略(ConcreteStrategy)角色：以Strategy接口实现某具体算法
环境(Context)角色：持有一个Strategy类的引用，用一个ConcreteStrategy对象来配置

## 四、策略模式的优点和缺点
### 策略模式的优点：
1、策略模式提供了管理相关的算法族的办法

2、策略模式提供了可以替换继承关系的办法 将算封闭在独立的Strategy类中使得你可以独立于其Context改变它

3、使用策略模式可以避免使用多重条件转移语句。
### 策略模式的缺点：
1、客户必须了解所有的策略 这是策略模式一个潜在的缺点

2、Strategy和Context之间的通信开销

3、策略模式会造成很多的策略类

## 五、策略模式适用场景
1、许多相关的类仅仅是行为有异。“策略”提供了一种用多个行为中的一个行为来配置一个类的方法

2、需要使用一个算法的不同变体。

3、算法使用客户不应该知道的数据。可使用策略模式以避免暴露复杂的，与算法相关的数据结构

4、一个类定义了多种行为，并且 这些行为在这个类的操作中以多个形式出现。将相关的条件分支移和它们各自的Strategy类中以代替这些条件语句

## 六、策略模式与其它模式
Template模式：模板方法模式与策略模式的不同在于，策略模式使用委派的方法提供不同的算法行为，而模板方法使用继承的方法提供不同的算法行为

享元模式(flyweight模式)：如果有多个客户端对象需要调用 同样的一睦策略类的话，就可以使它们实现享元模式