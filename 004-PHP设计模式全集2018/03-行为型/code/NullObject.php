<?php

/**
 * 在空对象模式（Null Object Pattern）中，一个空对象取代 NULL 对象实例的检查。
 * Null 对象不是检查空值，而是反应一个不做任何动作的关系。这样的 Null 对象也可以在数据不可用的时候提供默认的行为。
 * 在空对象模式中，我们创建一个指定各种要执行的操作的抽象类和扩展该类的实体类，还创建一个未对该类做任何实现的空对象类，该空对象类将无缝地使用在需要检查空值的地方。
 */

//（1）AbstractCustomer.class.php（抽象父类）
namespace NullObject;

abstract class AbstractCustomer
{
    protected $name;

    public abstract function isNil():bool;

    public abstract function getName() : string;
}

// （2）RealCustomer.class.php (真实用户类)
namespace NullObject;

class RealCustomer extends AbstractCustomer
{
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    public function isNil():bool
    {
        return false;
    }

    public function getName() : string
    {
        return $this->name;
    }
}

// （3）NullCustomer.class.php （空对象代替类）
namespace NullObject;

class NullCustomer extends AbstractCustomer
{
    public function getName() : string
    {
        return "Not Available in Customer Database";
    }

    public function isNil():bool
    {
        return true;
    }
}

// （4）CustomerFactory.class.php （用户工厂类）
namespace NullObject;

class CustomerFactory
{
    public static $users = [];

    public static function getCustomer($name)
    {
        if (in_array($name, self::$users)){
            return new RealCustomer($name);
        }
        return new NullCustomer();
    }
}

// (5)nullObject.php
spl_autoload_register(function ($className){
    $className = str_replace('\\','/',$className);
    include $className.".class.php";
});

use NullObject\CustomerFactory;

CustomerFactory::$users = ["Rob", "Joe", "Julie"];

$customer1 = CustomerFactory::getCustomer('Rob');
$customer2 = CustomerFactory::getCustomer('Bob');
$customer3 = CustomerFactory::getCustomer('Joe');
$customer4 = CustomerFactory::getCustomer('Julie');

echo $customer1->getName();
echo '<br/>';

echo $customer2->getName();
echo '<br/>';

echo $customer3->getName();
echo '<br/>';

echo $customer4->getName();
echo '<br/>';

