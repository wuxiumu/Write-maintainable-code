<?php
header("Content-type:text/html;Charset=utf-8");

/**
 * Interface Subject 抽象主题角色
 *
 * 定义RealSubject和Proxy共同具备的东西
 */
interface Subject
{
    public function say();
    public function run();
}

/**
 * Class RealSubject 真正主题角色
 */
class RealSubject implements Subject
{
    // 姓名
    private $_name;

    /**
     * RealSubject constructor. 构造方法
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->_name = $name;
    }

    /**
     * 说话
     */
    public function say()
    {
        echo $this->_name."在说话<br>";
    }

    /**
     * 在跑步
     */
    public function run(){
        echo $this->_name."在跑步<br>";
    }
}

/**
 * Class Proxy 代理对象
 */
class Proxy implements Subject
{
    // 真实主题对象
    private $_realSubject = null;

    /**
     * Proxy constructor. 构造方法，依赖注入方式储存真实对象
     *
     * @param RealSubject|null $realSubject
     */
    public function __construct(RealSubject $realSubject = null)
    {
        if (empty($realSubject)) {
            $this->_realSubject = new RealSubject();
        } else {
            $this->_realSubject = $realSubject;
        }
    }

    /**
     * 调用说话方法
     */
    public function say()
    {
        $this->_realSubject->say();
    }

    /**
     * 调用跑步方法
     */
    public function run()
    {
        $this->_realSubject->run();
    }
}

/**
 * Class Client 本地测试
 */
class Client
{
    public static function test()
    {
        // 创建
        $subject = new RealSubject("张三");
        // 代理
        $proxy = new Proxy($subject);
        // 张三在说话
        $proxy->say();
        // 张三在跑步
        $proxy->run();
    }
}

// 测试
Client::test();