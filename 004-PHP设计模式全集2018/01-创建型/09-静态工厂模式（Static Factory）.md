静态工厂模式（Static Factory）

## 1.9.1. 目的
与抽象工厂模式类似，此模式用于创建一系列相关或相互依赖的对象。 『静态工厂模式』与『抽象工厂模式』的区别在于，只使用一个静态方法来创建所有类型对象， 此方法通常被命名为 factory 或 build。

## 1.9.2. 例子
Zend Framework: Zend_Cache_Backend 或 _Frontend 使用工厂方法创建缓存后端或前端

## 1.9.3. UML 图
![](/000-imgs/wZFkQjM3UG.png)

## 1.9.4. 代码
你可以在 [GitHub](https://github.com/domnikl/DesignPatternsPHP/tree/master/Creational/StaticFactory) 上找到这个代码。

StaticFactory.php
```
<?php

namespace DesignPatterns\Creational\StaticFactory;

/**
 * 注意点1: 记住，静态意味着全局状态，因为它不能被模拟进行测试，所以它是有弊端的
 * 注意点2: 不能被分类或模拟或有多个不同的实例。
 */
final class StaticFactory
{
    /**
    * @param string $type
    *
    * @return FormatterInterface
    */
    public static function factory(string $type): FormatterInterface
    {
        if ($type == 'number') {
            return new FormatNumber();
        }

        if ($type == 'string') {
            return new FormatString();
        }

        throw new \InvalidArgumentException('Unknown format given');
    }
}
```

FormatterInterface.php
```
<?php

namespace DesignPatterns\Creational\StaticFactory;

interface FormatterInterface
{
}
```

FormatString.php
```
<?php

namespace DesignPatterns\Creational\StaticFactory;

class FormatString implements FormatterInterface
{
}
```

FormatNumber.php
```
<?php

namespace DesignPatterns\Creational\StaticFactory;

class FormatNumber implements FormatterInterface
{
}
```

## 1.9.5. 测试
Tests/StaticFactoryTest.php
```
<?php

namespace DesignPatterns\Creational\StaticFactory\Tests;

use DesignPatterns\Creational\StaticFactory\StaticFactory;
use PHPUnit\Framework\TestCase;

class StaticFactoryTest extends TestCase
{
    public function testCanCreateNumberFormatter()
    {
        $this->assertInstanceOf(
            'DesignPatterns\Creational\StaticFactory\FormatNumber',
            StaticFactory::factory('number')
        );
    }

    public function testCanCreateStringFormatter()
    {
        $this->assertInstanceOf(
            'DesignPatterns\Creational\StaticFactory\FormatString',
            StaticFactory::factory('string')
        );
    }

    /**
    * @expectedException \InvalidArgumentException
    */
    public function testException()
    {
        StaticFactory::factory('object');
    }
}
```

>其他

简单工厂模式 【静态工厂方法模式】(Static Factory Method)

是类的创建模式

## 工厂模式的几种形态：
　　1、简单工厂模式（Simple Factory） |又叫做  静态工厂方法模式（Static Factory Method）

　　2、工厂方法模式(Factory Method)	|又叫做	多态性工厂模式(Polymorphic Factory)

　　3、抽象工厂模式(Abstract Factory)	|又叫做	工具箱模式(ToolKit)
## 代码实例
## 1、首先大家要明白，简单工厂模式有三个角色

　　1、抽象角色

　　2、具体角色

　　3、工厂角色 ： 负责获取某个具体角色的实例

## 2、下面的事例，是使用抽象类直接创建具体产品实例。省去了工厂角色

　　这里有几个需要注意的点：

　　1、抽象类AbstractUser 有一个方法getInstance 这个方法是静态的，不然我们必须要实例化才能使用，但是它是一个抽象类，不能实例化。所以必须要是静态的方法

　　2、大家还发现getInstance 定义了final ，final的意义就是这个方法不需要被具体类继承

```
<?
/*
* 定义了 User接口.
* 和子类 NormalUser,VipUser,InnerUser 
*/
//User接口,定义了三个抽象方法.
interface User{
    public function getName();
    public function setName($_name);
    public function getDiscount();
}

abstract class AbstractUser implements User{
    private $name = ""; //名字
    protected  $discount = 0; //折扣
    protected  $grade = "";  //级别
    
    final public static function getInstance($userType , $name){
        if(class_exists($userType)){
            $instance = new $userType($name);
            if($instance instanceof self){
                return $instance;
            }
        }
        throw new Exception("Error no the userType");
    }

    public function __construct($_name){
        $this->setName($_name);
    }
    public function getName(){
        return $this->name;
    }
    public function setName($_name){
        $this->name = $_name;
    }
    public function getDiscount(){
        return $this->discount;
    }
    
    public function getGrade(){
        return $this->grade;
    }
}

class NormalUser extends AbstractUser  {
    protected  $discount = 1.0;
    protected  $grade = "NormalUser";
}

class VipUser extends AbstractUser {
    protected  $discount = 0.8;
    protected  $grade = "VipUser";
}

class InnerUser extends AbstractUser {
    protected  $discount = 0.7;
    protected  $grade = "InnerUser";
}


$user = AbstractUser::getInstance('NormalUser' , 'zhangsan');
var_dump($user);
```