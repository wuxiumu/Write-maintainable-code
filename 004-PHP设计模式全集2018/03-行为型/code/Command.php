<?php
/**
 * 命令模式
 *
 * 将一个请求封装为一个对象从而使你可用不同的请求对客户进行参数化,对请求排除或记录请求日志,以及支持可取消的操作
 */
// 命令接口
interface Command
{
    public function execute();
}

class Invoker
{
    private $_command = array();
    public function setCommand($command) {
        $this->_command[] = $command;
    }
    public function executeCommand()
    {
        foreach($this->_command as $command)
        {
            $command->execute();
        }
    }
    public function removeCommand($command)
    {
        $key = array_search($command, $this->_command);
        if($key !== false)
        {
            unset($this->_command[$key]);
        }
    }
}

// 命令接受者
class Receiver
{
    private $_name = null;
    public function __construct($name) {
        $this->_name = $name;
    }
    public function action()
    {
        echo $this->_name." 执行攻击命令（action）" .PHP_EOL;
    }
    public function action1()
    {
        echo $this->_name." 执行防御命令（action1）" .PHP_EOL;
    }
}
// 具体的命令
class ConcreteCommand implements Command
{
    private $_receiver;
    public function __construct($receiver)
    {
        $this->_receiver = $receiver;
    }
    public function execute()
    {
        $this->_receiver->action();
    }
}
// 具体命令1
class ConcreteCommand1 implements Command
{
    private $_receiver;
    public function __construct($receiver)
    {
        $this->_receiver = $receiver;
    }
    public function execute()
    {
        $this->_receiver->action1();
    }
}
// 具体命令2
class ConcreteCommand2 implements Command
{
    private $_receiver;
    public function __construct($receiver)
    {
        $this->_receiver = $receiver;
    }
    public function execute()
    {
        $this->_receiver->action();
        $this->_receiver->action1();
    }
}
$objRecevier = new Receiver("小狗");
$objRecevier1 = new Receiver("刺蛇");
$objRecevier2 = new Receiver("雷兽");
$objCommand = new ConcreteCommand($objRecevier);
$objCommand1 = new ConcreteCommand1($objRecevier);
$objCommand2 = new ConcreteCommand($objRecevier1);
$objCommand3 = new ConcreteCommand1($objRecevier1);
$objCommand4 = new ConcreteCommand2($objRecevier2); // 使用 Recevier的两个方法
$objInvoker = new Invoker();
$objInvoker->setCommand($objCommand);
$objInvoker->setCommand($objCommand1);
$objInvoker->executeCommand();
$objInvoker->removeCommand($objCommand1);
$objInvoker->executeCommand();
$objInvoker->setCommand($objCommand2);
$objInvoker->setCommand($objCommand3);
$objInvoker->setCommand($objCommand4);
$objInvoker->executeCommand();
?>