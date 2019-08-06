命令行模式（Command）

## 3.2.1. 目的
为了封装调用和解耦。

我们有一个调用程序和一个接收器。 

这种模式使用「命令行」将方法调用委托给接收器并且呈现相同的「执行」方法。

因此，调用程序只知道调用「执行」去处理客户端的命令。接收器会从调用程序中分离出来。

这个模式的另一面是取消方法的 execute ()，也就是 undo () 。

命令行也可以通过最小量的复制粘贴和依赖组合（不是继承）被聚合，从而组合成更复杂的命令集。

## 3.2.2. 例子
文本编辑器：所有事件都是可以被解除、堆放，保存的命令。
Symfony2：SF2 命令可以从 CLI 运行，它的建立只需考虑到命令行模式。
大型 CLI 工具使用子程序来分发不同的任务并将它们封装在「模型」中，每个模块都可以通过命令行模式实现（例如：vagrant）。
## 3.2.3. UML 图
![](/000-imgs/hSXJ3cYequ.png)

## 3.2.4. Code
你也可以在 GitHub 上查看 源码

CommandInterface.php
```
<?php

namespace DesignPatterns\Behavioral\Command;

interface CommandInterface
{
    /**
     * 这是在命令行模式中很重要的方法，
     * 这个接收者会被载入构造器
     */
    public function execute();
}
```

HelloCommand.php
```
<?php

namespace DesignPatterns\Behavioral\Command;

/**
 * 这个具体命令，在接收器上调用 "print" ，
 *  但是外部调用者只知道，这个是否可以执行。
 */
class HelloCommand implements CommandInterface
{
    /**
     * @var Receiver
     */
    private $output;

    /**
     * 每个具体的命令都来自于不同的接收者。
     * 这个可以是一个或者多个接收者，但是参数里必须是可以被执行的命令。
     *
     * @param Receiver $console
     */
    public function __construct(Receiver $console)
    {
        $this->output = $console;
    }

    /**
     * 执行和输出 "Hello World".
     */
    public function execute()
    {
        // 有时候，这里没有接收者，并且这个命令执行所有工作。
        $this->output->write('Hello World');
    }
}
```

Receiver.php
```
<?php

namespace DesignPatterns\Behavioral\Command;

/**
 * 接收方是特定的服务，有自己的 contract ，只能是具体的实例。
 */
class Receiver
{
    /**
     * @var bool
     */
    private $enableDate = false;

    /**
     * @var string[]
     */
    private $output = [];

    /**
     * @param string $str
     */
    public function write(string $str)
    {
        if ($this->enableDate) {
            $str .= ' ['.date('Y-m-d').']';
        }

        $this->output[] = $str;
    }

    public function getOutput(): string
    {
        return join("\n", $this->output);
    }

    /**
     * 可以显示消息的时间
     */
    public function enableDate()
    {
        $this->enableDate = true;
    }

    /**
     * 禁止显示消息的时间
     */
    public function disableDate()
    {
        $this->enableDate = false;
    }
}
```

Invoker.php
```
<?php

namespace DesignPatterns\Behavioral\Command;

/**
 *调用者使用这种命令。
 * 比例 : 一个在 SF2 中的应用
 */
class Invoker
{
    /**
     * @var CommandInterface
     */
    private $command;

    /**
     * 在这种调用者中，我们发现，订阅命令也是这种方法
     * 还包括：堆栈、列表、集合等等
     *
     * @param CommandInterface $cmd
     */
    public function setCommand(CommandInterface $cmd)
    {
        $this->command = $cmd;
    }

    /**
     * 执行这个命令；
     * 调用者也是用这个命令。
     */
    public function run()
    {
        $this->command->execute();
    }
}
```

## 3.2.5. Test

Tests/CommandTest.php
```
<?php

namespace DesignPatterns\Behavioral\Command\Tests;

use DesignPatterns\Behavioral\Command\HelloCommand;
use DesignPatterns\Behavioral\Command\Invoker;
use DesignPatterns\Behavioral\Command\Receiver;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    public function testInvocation()
    {
        $invoker = new Invoker();
        $receiver = new Receiver();

        $invoker->setCommand(new HelloCommand($receiver));
        $invoker->run();
        $this->assertEquals('Hello World', $receiver->getOutput());
    }
}
```
>其他

命令模式的理解，关键有2点：

## 1. 使用接口。

通常命令模式的接口中只有一个方法。 实现类的方法有不同的功能，覆盖接口中的方法。在面向对象编程中，大量使用if…else…，或者switch…case…这样的条件选择语句是“最差实践”。通常这类代码，意味着有重构的余地。命令模式就是干掉条件选择语句的利器。

首先提供一个接口：
```
public interface Command {
  public void execute();
}
```

然后提供这个接口的实现类。每一个实现类的方法就是if…else…的一个代码块中的代码。这样，调用方直接把一个具体类的实例传进来即可。如：
``` 
Public void test(Command para){
  Para.execute();
}
```

不需要再判断出现了哪种情况，应该执行哪一段代码。一切的问题都由调用方处理。

如果不使用命令模式，那么如果情况逐步增多，如，从原来的2种，增加到20种，那么方法中的判断就会从1次增加到19次。而使用命令模式，仅仅调用方需要从2个实现类增加到20个实现类即可。上面的test方法根本不需要做任何改变。

## 2. 主要的用途是，使用参数回调模式。

最主要使用命令模式的方式是使用参数回调模式。命令接口作为方法的参数传递进来。然后，在方法体内回调该接口。

当然，命令模式还可以使用其他方式来使用。不一定非用参数回调模式。