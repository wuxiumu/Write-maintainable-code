代理模式（Proxy）

## 2.10.1. 目的
代理模式（Proxy）为其他对象提供一种代理以控制对这个对象的访问。使用代理模式创建代理对象，让代理对象控制目标对象的访问（目标对象可以是远程的对象、创建开销大的对象或需要安全控制的对象），并且可以在不改变目标对象的情况下添加一些额外的功能。

在某些情况下，一个客户不想或者不能直接引用另一个对象，而代理对象可以在客户端和目标对象之间起到中介的作用，并且可以通过代理对象去掉客户不能看到的内容和服务或者添加客户需要的额外服务。

经典例子就是网络代理，你想访问 Facebook 或者 Twitter ，如何绕过 GFW？找个代理网站。

## 2.10.2. Examples
Doctrine2 使用代理来实现框架的 “魔术”（例如：延迟加载），而用户仍然使用他们自己的实体类且不会使用到代理。

## 2.10.3. UML 图
![](/000-imgs/c9IjRLIGzP.png)

## 2.10.4. 代码
源代码在这里： [GitHub](https://github.com/domnikl/DesignPatternsPHP/tree/master/Structural/Proxy)

Record.php
```
<?php

namespace DesignPatterns\Structural\Proxy;

/**
 * @property 用户名
 */
class Record
{
    /**
     * @var string[]
     */
    private $data;

    /**
     * @param string[] $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param string $name
     * @param string  $value
     */
    public function __set(string $name, string $value)
    {
        $this->data[$name] = $value;
    }

    public function __get(string $name): string
    {
        if (!isset($this->data[$name])) {
            throw new \OutOfRangeException('Invalid name given');
        }

        return $this->data[$name];
    }
}
```

RecordProxy.php
```
<?php

namespace DesignPatterns\Structural\Proxy;

class RecordProxy extends Record
{
    /**
     * @var bool
     */
    private $isDirty = false;

    /**
     * @var bool
     */
    private $isInitialized = false;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);
        // 当记录有数据的时候，将 initialized 标记为 true ，
        // 因为记录将保存我们的业务逻辑，我们不希望在 Record 类里面实现这个行为
        // 而是在继承了 Record 的代理类中去实现。
        if (count($data) > 0) {
            $this->isInitialized = true;
            $this->isDirty = true;
        }
    }

    /**
     * @param string $name
     * @param string  $value
     */
    public function __set(string $name, string $value)
    {
        $this->isDirty = true;

        parent::__set($name, $value);
    }

    public function isDirty(): bool
    {
        return $this->isDirty;
    }
}
```

测试代码
```
<?php

    namespace DesignPatterns\Structural\Proxy\Tests;

    use DesignPatterns\Structural\Proxy\Record;
    use DesignPatterns\Structural\Proxy\RecordProxy;

    class ProxyTest extends \PHPUnit_Framework_TestCase
    {
        public function testSetAttribute(){
            $data = [];
            $proxy = new RecordProxy($data);
            $proxy->xyz = false;
            $this->assertTrue($proxy->xyz===false);
        }
    }
```    

>其他

## 概念
代理模式(Proxy Pattern) ：一种对象结构型模式。给某一个对象提供一个代理，并由代理对象控制对原对象的引用。

## UML
![](/000-imgs/4287163633-583271c11ad4c_articlex.png)

## 角色
- 抽象主题角色（Subject）：定义了RealSubject和Proxy公用接口，这样就在任何使用RealSubject的地方都可以使用Proxy。

- 真正主题角色（RealSubject）：定义了Proxy所代表的真实实体。

- 代理对象（Proxy）：保存一个引用使得代理可以访问实体，并提供一个与RealSubject接口相同的接口，这样代理可以用来代替实体(RealSubject)。

### 适用场景
根据代理模式的使用目的，常见的代理模式有以下几种类型：

- 远程(Remote)代理：为一个位于不同的地址空间的对象提供一个本地 的代理对象，这个不同的地址空间可以是在同一台主机中，也可是在 另一台主机中，远程代理又叫做大使(Ambassador)。

- 虚拟(Virtual)代理：如果需要创建一个资源消耗较大的对象，先创建一个消耗相对较小的对象来表示，真实对象只在需要时才会被真正创建。

- Copy-on-Write代理：它是虚拟代理的一种，把复制（克隆）操作延迟 到只有在客户端真正需要时才执行。一般来说，对象的深克隆是一个 开销较大的操作，Copy-on-Write代理可以让这个操作延迟，只有对象被用到的时候才被克隆。

- 保护(Protect or Access)代理：控制对一个对象的访问，可以给不同的用户提供不同级别的使用权限。

- 缓冲(Cache)代理：为某一个目标操作的结果提供临时的存储空间，以便多个客户端可以共享这些结果。

- 防火墙(Firewall)代理：保护目标不让恶意用户接近。

- 同步化(Synchronization)代理：使几个用户能够同时使用一个对象而没有冲突。

- 智能引用(Smart Reference)代理：当一个对象被引用时，提供一些额外的操作，如将此对象被调用的次数记录下来等。

## 优点和缺点
### 优点：
- 代理模式能够协调调用者和被调用者，在一定程度上降低了系统的耦合度。

- 远程代理使得客户端可以访问在远程机器上的对象，远程机器 可能具有更好的计算性能与处理速度，可以快速响应并处理客户端请求。

- 虚拟代理通过使用一个小对象来代表一个大对象，可以减少系统资源的消耗，对系统进行优化并提高运行速度。

- 保护代理可以控制对真实对象的使用权限。

### 缺点：
- 由于在客户端和真实主题之间增加了代理对象，因此 有些类型的代理模式可能会造成请求的处理速度变慢。

- 实现代理模式需要额外的工作，有些代理模式的实现非常复杂。