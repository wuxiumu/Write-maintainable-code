工厂方法模式（Factory Method）

## 1.3.1. 目的
对比简单工厂模式的优点是，您可以将其子类用不同的方法来创建一个对象。

举一个简单的例子，这个抽象类可能只是一个接口。

这种模式是「真正」的设计模式， 因为他实现了 S.O.L.I.D 原则中「D」的 「依赖倒置」。

这意味着工厂方法模式取决于抽象类，而不是具体的类。 这是与简单工厂模式和静态工厂模式相比的优势。

## 1.3.2. UML 图
![](/000-imgs/20190726152257.png)

## 1.3.3. 代码
你可以在  [GitHub](https://github.com/domnikl/DesignPatternsPHP/tree/master/Creational/Multiton) 查看这段代码

Logger.php
```
<?php

namespace DesignPatterns\Creational\FactoryMethod;

interface Logger
{
    public function log(string $message);
}
```

StdoutLogger.php
```
<?php

namespace DesignPatterns\Creational\FactoryMethod;

class StdoutLogger implements Logger
{
    public function log(string $message)
    {
        echo $message;
    }
}
```

FileLogger.php
```
<?php

namespace DesignPatterns\Creational\FactoryMethod;

class FileLogger implements Logger
{
    /**
     * @var string
     */
    private $filePath;
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }
    public function log(string $message)
    {
        file_put_contents($this->filePath, $message . PHP_EOL, FILE_APPEND);
    }
}
```

LoggerFactory.php
```
<?php

namespace DesignPatterns\Creational\FactoryMethod;

interface LoggerFactory
{
    public function createLogger(): Logger;
}
```

StdoutLoggerFactory.php
```
<?php

namespace DesignPatterns\Creational\FactoryMethod;

class StdoutLoggerFactory implements LoggerFactory
{
    public function createLogger(): Logger
    {
        return new StdoutLogger();
    }
}
```

FileLoggerFactory.php
```
<?php

namespace DesignPatterns\Creational\FactoryMethod;

class FileLoggerFactory implements LoggerFactory
{
    /**
     * @var string
     */
    private $filePath;
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }
    public function createLogger(): Logger
    {
        return new FileLogger($this->filePath);
    }
}
```

## 1.3.4. 测试
Tests/FactoryMethodTest.php
```
<?php

namespace DesignPatterns\Creational\FactoryMethod\Tests;
use DesignPatterns\Creational\FactoryMethod\FileLogger;
use DesignPatterns\Creational\FactoryMethod\FileLoggerFactory;
use DesignPatterns\Creational\FactoryMethod\StdoutLogger;
use DesignPatterns\Creational\FactoryMethod\StdoutLoggerFactory;
use PHPUnit\Framework\TestCase;

class FactoryMethodTest extends TestCase
{
    public function testCanCreateStdoutLogging()
    {
        $loggerFactory = new StdoutLoggerFactory();
        $logger = $loggerFactory->createLogger();
        $this->assertInstanceOf(StdoutLogger::class, $logger);
    }
    public function testCanCreateFileLogging()
    {
        $loggerFactory = new FileLoggerFactory(sys_get_temp_dir());
        $logger = $loggerFactory->createLogger();
        $this->assertInstanceOf(FileLogger::class, $logger);
    }
}
```

> 其他

面向对象编程中，工厂模式是我们最常用的实例化对象模式，工厂类就是一个专门用来创建其它对象的类，工厂类在多态性编程实践中是非常重要的。它允许动态替换类，修改配置，会使应用程序更加灵活。掌握工厂模式对Web开发是必不可少的，它会给你的系统带来更大的可扩展性和尽量少的修改量。

工厂模式通常用来返回类似接口的不同的类，工厂的一种常见用法就是创建多态的提供者。

通常工厂模式有一个关键的构造，即一般被命名为factory的静态方法。这个静态方法可以接受任意数量的参数，并且必须返回一个对象。

一个非常贴近生活的例子来告诉你什么是工厂模式

但是工厂模式真的是个累赘吗？其实并不是！他能够作为一种设计模式流传至今，一定是有他的道理的！只不过我们看到的例子只能说明工厂模式是什么，并不能很好说明工厂模式的优点，所以我们学会后并不知道为什么要使用工厂模式，以及什么时候应该去使用工厂模式！

其实工厂模式在我们的现实生活中非常常见，下面我举个生活中的例子，大家应该就能明白工厂模式的用处在哪里了！

麦当劳大家都吃过吧？我们去点餐的时候，我们可以点一个汉堡，一杯可乐，一个薯条。我们还可以点一杯可乐，一个薯条。点完之后点餐员会问我们一句还要别的吗？你说不要了！ 然后你的这一份餐就点完了，可以给钱了。咦，我们发现这是一个建造者模式（Builder Pattern）啊！

（ps：这确实是突然发现的，之前写建造者模式那篇文章的时候并没有想到这个例子）

## 基本的工厂类：
```
<?php

 class Fruit {
    // 对象从工厂类返回
 }
 Class FruitFactory {
    public static function factory() {
        // 返回对象的一个新实例
        return new Fruit();
    }
 }

 // 调用工厂
 $instance = FruitFactory::factory();
?>
```

## 利用工厂类生产对象：
```
<?php

class Example
{

  // The parameterized factory method
  public static function factory($type)
  {
    if (include_once 'Drivers/' . $type . '.php') {
       $classname = 'Driver_' . $type;
       return new $classname;
    } else {
       throw new Exception('Driver not found');
    }
  }
}

// Load a MySQL Driver
$mysql = Example::factory('MySQL');

// Load an SQLite Driver
$sqlite = Example::factory('SQLite');
?>
```

## 一个完整的工厂类：

下面的程序定义了一个通用的工厂类，它生产能够保存你所有操作的空对象，你可以获得一个实例，这些操作都在那个实例中了。
```
<?php
  /**
   * Generic Factory class
   * This Factory will remember all operations you perform on it,
   * and apply them to the object it instantiates.
   */
  class FruitFactory {
    private $history, $class, $constructor_args;
    /**
     * Create a factory of given class. Accepts extra arguments to be passed to
     * class constructor.
     */
    function __construct( $class ) {
      $args = func_get_args();
      $this->class = $class;
      $this->constructor_args = array_slice( $args, 1 );
    }
    function __call( $method, $args ) {
      $this->history[] = array(
        'action'  => 'call',
        'method'  => $method,
        'args'  => $args
      );
    }
    function __set( $property, $value ) {
      $this->history[] = array(
        'action'  => 'set',
        'property'  => $property,
        'value'    => $value
      );
    }
    /**
     * Creates an instance and performs all operations that were done on this MagicFactory
     */
    function instance() {
      # use Reflection to create a new instance, using the $args
      $reflection_object = new ReflectionClass( $this->class ); 
      $object = $reflection_object->newInstanceArgs( $this->constructor_args ); 
      # Alternative method that doesn't use ReflectionClass, but doesn't support variable
      # number of constructor parameters.
      //$object = new $this->class();
      # Repeat all remembered operations, apply to new object.
      foreach( $this->history as $item ) {
        if( $item['action'] == 'call' ) {
          call_user_func_array( array( $object, $item['method'] ), $item['args'] );
        }
        if( $item['action'] == 'set' ) {
          $object->{$item['property']} = $item['value'];
        }
      }
      # Done
      return $object;
    }
  }
  class Fruit {
    private $name, $color;
    public $price;
    function __construct( $name, $color ) {
      $this->name = $name;
      $this->color = $color;
    }
    function setName( $name ) {
      $this->name = $name;
    }
    function introduce() {
      print "Hello, this is an {$this->name} {$this->sirname}, its price is {$this->price} RMB.";
    }
  }
  # Setup a factory
  $fruit_factory = new FruitFactory('Fruit', 'Apple', 'Gonn');
  $fruit_factory->setName('Apple');
  $fruit_factory->price = 2;
  # Get an instance
  $apple = $fruit_factory->instance();
  $apple->introduce();
?>
```
工厂模式主要是为创建对象提供过渡接口，以便将创建对象的具体过程屏蔽隔离起来，达到提高灵活性的目的。

## 工厂模式可以分为三类：

简单工厂模式（Simple Factory）

工厂方法模式（Factory Method）

抽象工厂模式（Abstract Factory）

这三种模式从上到下逐步抽象，并且更具一般性。

简单工厂模式又称静态工厂方法模式；从命名上就可以看出这个模式一定很简单。

它存在的目的很简单：定义一个用于创建对象的接口。

工厂方法模式去掉了简单工厂模式中工厂方法的静态属性，使得它可以被子类继承。

这样在简单工厂模式里集中在工厂方法上的压力可以由工厂方法模式里不同的工厂子类来分担。

工厂方法模式仿佛已经很完美的对对象的创建进行了包装，使得客户程序中仅仅处理抽象产品角色提供的接口。

那我们是否一定要在代码中遍布工厂呢？大可不必。也许在下面情况下你可以考虑使用工厂方法模式：

当客户程序不需要知道要使用对象的创建过程。

客户程序使用的对象存在变动的可能，或者根本就不知道使用哪一个具体的对象。