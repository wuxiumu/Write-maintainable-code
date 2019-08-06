备忘录模式（Memento）

## 3.5.1. 目的
它提供了在不破坏封装（对象不需要具有返回当前状态的函数）的情况下恢复到之前状态（使用回滚）或者获取对象的内部状态。

备忘录模式使用 3 个类来实现：Originator，Caretaker 和 Memento。

Memento —— 负责存储 Originator 的 唯一内部状态 ，它可以包含： string，number， array，类的实例等等。Memento 「不是公开的类」（任何人都不应该且不能更改它），并防止 Originator 以外的对象访问它，它提供 2 个接口：Caretaker 只能看到备忘录的窄接口，他只能将备忘录传递给其他对象。Originator 却可看到备忘录的宽接口，允许它访问返回到先前状态所需要的所有数据。

Originator —— 它负责创建 Memento  ，并记录 外部对象当前时刻的状态， 并可使用 Memento 恢复内部状态。Originator 可根据需要决定 Memento 存储 Originator 的哪些内部状态。 Originator 也许（不是应该）有自己的方法（methods）。 但是，他们 不能更改已保存对象的当前状态。

Caretaker —— 负责保存 Memento。 它可以修改一个对象；决定 Originator 中对象当前时刻的状态； 从 Originator 获取对象的当前状态； 或者回滚 Originator 中对象的状态。

为了方便大家理解，以上翻译跟原文有少许出入

## 3.5.2. 例子
发送一个随机数

并将这个随机数存在时序机中

保存之前控制  [ORM Model](http://en.wikipedia.org/wiki/Object-relational_mapping)  中的状态

## 3.5.3. UML 图
![](/000-imgs/3ZBanRSn95.png)

## 3.5.4. 代码
你可以在  [GitHub](https://github.com/domnikl/DesignPatternsPHP/tree/master/Behavioral/Memento) 查看这段代码。

Memento.php
```
<?php

namespace DesignPatterns\Behavioral\Memento;

class Memento
{
    /**
     * @var State
     */
    private $state;

    /**
     * @param State $stateToSave
     */
    public function __construct(State $stateToSave)
    {
        $this->state = $stateToSave;
    }

    /**
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }
}
```

State.php
```
<?php

namespace DesignPatterns\Behavioral\Memento;

class State
{
    const STATE_CREATED = 'created';
    const STATE_OPENED = 'opened';
    const STATE_ASSIGNED = 'assigned';
    const STATE_CLOSED = 'closed';

    /**
     * @var string
     */
    private $state;

    /**
     * @var string[]
     */
    private static $validStates = [
        self::STATE_CREATED,
        self::STATE_OPENED,
        self::STATE_ASSIGNED,
        self::STATE_CLOSED,
    ];

    /**
     * @param string $state
     */
    public function __construct(string $state)
    {
        self::ensureIsValidState($state);

        $this->state = $state;
    }

    private static function ensureIsValidState(string $state)
    {
        if (!in_array($state, self::$validStates)) {
            throw new \InvalidArgumentException('Invalid state given');
        }
    }

    public function __toString(): string
    {
        return $this->state;
    }
}
```

Ticket.php
```
<?php

namespace DesignPatterns\Behavioral\Memento;

/**
 * Ticket 是  Originator  的原始副本
 */
class Ticket
{
    /**
     * @var State
     */
    private $currentState;

    public function __construct()
    {
        $this->currentState = new State(State::STATE_CREATED);
    }

    public function open()
    {
        $this->currentState = new State(State::STATE_OPENED);
    }

    public function assign()
    {
        $this->currentState = new State(State::STATE_ASSIGNED);
    }

    public function close()
    {
        $this->currentState = new State(State::STATE_CLOSED);
    }

    public function saveToMemento(): Memento
    {
        return new Memento(clone $this->currentState);
    }

    public function restoreFromMemento(Memento $memento)
    {
        $this->currentState = $memento->getState();
    }

    public function getState(): State
    {
        return $this->currentState;
    }
}
```

## 3.5.5. 测试
Tests/MementoTest.php
```
<?php

namespace DesignPatterns\Behavioral\Memento\Tests;

use DesignPatterns\Behavioral\Memento\State;
use DesignPatterns\Behavioral\Memento\Ticket;
use PHPUnit\Framework\TestCase;

class MementoTest extends TestCase
{
    public function testOpenTicketAssignAndSetBackToOpen()
    {
        $ticket = new Ticket();

        // 打开 ticket
        $ticket->open();
        $openedState = $ticket->getState();
        $this->assertEquals(State::STATE_OPENED, (string) $ticket->getState());

        $memento = $ticket->saveToMemento();

        // 分配 ticket
        $ticket->assign();
        $this->assertEquals(State::STATE_ASSIGNED, (string) $ticket->getState());

        // 现在已经恢复到已打开的状态，但需要验证是否已经克隆了当前状态作为副本
        $ticket->restoreFromMemento($memento);

        $this->assertEquals(State::STATE_OPENED, (string) $ticket->getState());
        $this->assertNotSame($openedState, $ticket->getState());
    }
}
```

>其他

## 一、意图
在不破坏封装性的前提下，捕获一个对象的内部状态，并在该对象之外保存这个状态。这样可以在以后把该对象的状态恢复到之前保存的状态。

## 二、备忘录模式结构图

![](/000-imgs/2015129112935334.jpg)

## 三、备忘录模式中主要角色

1、备忘录(Memento)角色：

存储发起人(Originator)对象的内部状态，而发起人根据需要决定备忘录存储发起人的哪些内部状态。

备忘录可以保护其内容不被发起人(Originator)对象之外的任何对象所读取。

2、发起人(Originator)角色：

创建一个含有当前的内部状态的备忘录对象

使用备忘录对象存储其内部状态

3、负责人(Caretaker)角色：

负责保存备忘录对象，不检查备忘录对象的内容

### 四、备忘录模式的优点和缺点
### 备忘录模式的优点：
1、有时一些发起人对象的内部信息必须保存在发起人对象以外的地方，但是必须要由发起人对象自己读取。

2、简化了发起人(Originator)类。发起人(Originator)不再需要管理和保存其内部状态的一个个版本，客户端可以自行管理它们所需要的这些状态的版本

3、当发起人角色的状态改变的时候，有可能这个状态无效，这时候就可以使用暂时存储起来的备忘录将状态复原。

### 备忘录模式的缺点：
1、如果发起人角色的状态需要完整地存储到备忘录对象中，那么在资源消耗上面备忘录对象会很昂贵。

2、当负责人角色将一个备忘录存储起来的时候，负责人可能并不知道这个状态会占用多大的存储空间，从而无法提醒用户一个操作是否会很昂贵。

3、当发起人角色的状态改变的时候，有可能这个状态无效。

## 五、备忘录模式适用场景
1、必须保存一个对象在某一个时刻的（部分）状态，这样以后需要时它才能恢复到先前的状态。

2、如果一个用接口来让其它对象直接得到这些状态，将会暴露对象的实现细节并破坏对象的封装性。

## 六、备忘录模式与其它模式
1、命令模式(command模式)：Command模式也可以用来恢复对象的状态，一般Command模式可以支持多级状态的回滚，Memento只是简单的恢复（快照）。在Command模式的每一个undo中，可以使用Memento来保存对象的状态。

2、迭代器模式(Iterator模式)：备忘录可以用于迭代