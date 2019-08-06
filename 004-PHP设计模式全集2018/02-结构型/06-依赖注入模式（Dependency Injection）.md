依赖注入模式（Dependency Injection）

## 2.6.1. 目的
用松散耦合的方式来更好的实现可测试、可维护和可扩展的代码。

控制反转（Inversion of Control，英文缩写为IoC）是框架的重要特征。

控制反转（IOC）是一种思想，依赖注入（DI）是实施这种思想的方法。

## 2.6.2. 用法
DatabaseConfiguration 被注入  DatabaseConnection  并获取所需的  $config 。如果没有依赖注入模式， 配置将直接创建  DatabaseConnection 。这对测试和扩展来说很不好。

## 2.6.3. 例子
Doctrine2 ORM 使用依赖注入。 例如，注入到  Connection  对象的配置。 对于测试而言， 可以轻松的创建可扩展的模拟数据并注入到  Connection  对象中。
Symfony 和 Zend Framework 2 已经有了依赖注入的容器。他们通过配置的数组来创建对象，并在需要的地方注入 (在控制器中)。

## 2.6.4. UML 图
![WHNWAjWM3i.png](/000-imgs/MihvMhMofO.png)

## 2.6.5. 代码
您可以在  [GitHub](https://github.com/domnikl/DesignPatternsPHP/tree/master/Structural/DependencyInjection) 查看这段代码

DatabaseConfiguration.php
```
<?php

namespace DesignPatterns\Structural\DependencyInjection;

class DatabaseConfiguration
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    public function __construct(string $host, int $port, string $username, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
```

DatabaseConnection.php
```
<?php

namespace DesignPatterns\Structural\DependencyInjection;

class DatabaseConnection
{
    /**
     * @var DatabaseConfiguration
     */
    private $configuration;

    /**
     * @param DatabaseConfiguration $config
     */
    public function __construct(DatabaseConfiguration $config)
    {
        $this->configuration = $config;
    }

    public function getDsn(): string
    {
        // 这仅仅是演示，而不是一个真正的  DSN
        // 注意，这里只使用了注入的配置。 所以，
        // 这里是关键的分离关注点。

        return sprintf(
            '%s:%s@%s:%d',
            $this->configuration->getUsername(),
            $this->configuration->getPassword(),
            $this->configuration->getHost(),
            $this->configuration->getPort()
        );
    }
}
```

## 2.6.6. 测试
Tests/DependencyInjectionTest.php
```
<?php

namespace DesignPatterns\Structural\DependencyInjection\Tests;

use DesignPatterns\Structural\DependencyInjection\DatabaseConfiguration;
use DesignPatterns\Structural\DependencyInjection\DatabaseConnection;
use PHPUnit\Framework\TestCase;

class DependencyInjectionTest extends TestCase
{
    public function testDependencyInjection()
    {
        $config = new DatabaseConfiguration('localhost', 3306, 'domnikl', '1234');
        $connection = new DatabaseConnection($config);

        $this->assertEquals('domnikl:1234@localhost:3306', $connection->getDsn());
    }
}
```

>其他

DI——Dependency Injection   依赖注入

IoC——Inversion of Control  控制反转

## 1、参与者都有谁？　　

答：一般有三方参与者，一个是某个对象；一个是IoC/DI的容器；另一个是某个对象的外部资源。又要名词解释一下，某个对象指的就是任意的、普通的Java对象; IoC/DI的容器简单点说就是指用来实现IoC/DI功能的一个框架程序；对象的外部资源指的就是对象需要的，但是是从对象外部获取的，都统称资源，比如：对象需要的其它对象、或者是对象需要的文件资源等等。

## 2、依赖：谁依赖于谁？为什么会有依赖？

答：某个对象依赖于IoC/DI的容器。依赖是不可避免的，在一个项目中，各个类之间有各种各样的关系，不可能全部完全独立，这就形成了依赖。传统的开发是使用其他类时直接调用，这会形成强耦合，这是要避免的。依赖注入借用容器转移了被依赖对象实现解耦。

## 3、注入：谁注入于谁？到底注入什么？

答：通过容器向对象注入其所需要的外部资源

## 4、控制反转：谁控制谁？控制什么？为什么叫反转？

答：IoC/DI的容器控制对象，主要是控制对象实例的创建。反转是相对于正向而言的，那么什么算是正向的呢？考虑一下常规情况下的应用程序，如果要在A里面使用C，你会怎么做呢？当然是直接去创建C的对象，也就是说，是在A类中主动去获取所需要的外部资源C，这种情况被称为正向的。那么什么是反向呢？就是A类不再主动去获取C，而是被动等待，等待IoC/DI的容器获取一个C的实例，然后反向的注入到A类中。

## 5、依赖注入和控制反转是同一概念吗？

答：从上面可以看出：依赖注入是从应用程序的角度在描述，可以把依赖注入描述完整点：应用程序依赖容器创建并注入它所需要的外部资源；而控制反转是从容器的角度在描述，描述完整点：容器控制应用程序，由容器反向的向应用程序注入应用程序所需要的外部资源。 