单例模式（Singleton）

单例模式被公认为是 反面模式，为了获得更好的可测试性和可维护性，请使用『依赖注入模式』。

## 1.8.1. 目的
在应用程序调用的时候，只能获得一个对象实例。

## 1.8.2. 例子
数据库连接

日志 (多种不同用途的日志也可能会成为多例模式)

在应用中锁定文件 (系统中只存在一个 ...)

## 1.8.3. UML 类图
![](/000-imgs/bVjGzeAlPV.png)

## 1.8.4. 代码部分
你也可以在 GitHub 中查看

Singleton.php
```
<?php

namespace DesignPatterns\Creational\Singleton;

final class Singleton
{
    /**
    * @var Singleton
    */
    private static $instance;

    /**
    * 通过懒加载获得实例（在第一次使用的时候创建）
    */
    public static function getInstance(): Singleton
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
    * 不允许从外部调用以防止创建多个实例
    * 要使用单例，必须通过 Singleton::getInstance() 方法获取实例
    */
    private function __construct()
    {
    }

    /**
    * 防止实例被克隆（这会创建实例的副本）
    */
    private function __clone()
    {
    }

    /**
    * 防止反序列化（这将创建它的副本）
    */
    private function __wakeup()
    {
    }
}
```

## 1.8.5. 测试
Tests/SingletonTest.php
```
<?php

namespace DesignPatterns\Creational\Singleton\Tests;

use DesignPatterns\Creational\Singleton\Singleton;
use PHPUnit\Framework\TestCase;

class SingletonTest extends TestCase
{
    public function testUniqueness()
    {
        $firstCall = Singleton::getInstance();
        $secondCall = Singleton::getInstance();

        $this->assertInstanceOf(Singleton::class, $firstCall);
        $this->assertSame($firstCall, $secondCall);
    }
}
```

>其他

## 为什么要使用PHP单例模式

1，php的应用主要在于数据库应用, 一个应用中会存在大量的数据库操作, 在使用面向对象的方式开发时, 如果使用单例模式,
则可以避免大量的new 操作消耗的资源,还可以减少数据库连接这样就不容易出现 too many connections情况。

2，如果系统中需要有一个类来全局控制某些配置信息, 那么使用单例模式可以很方便的实现. 这个可以参看zend Framework的FrontController部分。

3，在一次页面请求中, 便于进行调试, 因为所有的代码(例如数据库操作类db)都集中在一个类中, 我们可以在类中设置钩子, 输出日志，从而避免到处var_dump, echo

 
## 单例模式的实现

1，私有化一个属性用于存放唯一的一个实例

2，私有化构造方法，私有化克隆方法，用来创建并只允许创建一个实例

3，公有化静态方法，用于向系统提供这个实例

优点：因为静态方法可以在全局范围内被访问，当我们需要一个单例模式的对象时，只需调用getInstance方法，获取先前实例化的对象，无需重新实例化。

## 使用Trait关键字实现类似于继承单例类的功能

补充，大多数书籍介绍单例模式，都会讲三私一公，公优化静态方法作为提供对象的接口，私有属性用于存放唯一一个单例对象。私有化构造方法，私有化克隆方法保证只存在一个单例。

但实际上，虽然我们无法通过new 关键字和clone出一个新的对象，但我们若想得到一个新对象。还是有办法的，那就是通过序列化和反序列化得到一个对象。私有化sleep()和wakeup()方法依然无法阻止通过这种方法得到一个新对象。或许真得要阻止，你只能去__wakeup添加删除一个实例的代码，保证反序列化增加一个对象，你就删除一个。不过这样貌似有点怪异。