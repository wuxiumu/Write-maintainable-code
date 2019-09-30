<?php
/**
 * Interface Observable
 * define a observable interface
 */
interface Observable
{
    function attach(Observer $observer);
    function detach(Observer $observer);
    function notify();
}
/**
 * Class Login
 */
class Login implements Observable
{
    private $observers;
    public $status;
    public $ip;
    const LOGIN_ACCESS = 1;
    const LOGIN_WRONG_PASS = 2;
    const LOGIN_USER_UNKNOWN = 3;
    function __construct()
    {
        $this->observers = array();
    }
    /**
     * @param Observer $observer
     * attach a observer
     */
    function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }
    /**
     * @param Observer $observer
     * detach a observer
     */
    function detach(Observer $observer)
    {
        $newObservers = array();
        foreach ($this->observers as $key => $obs) {
            if ($obs !== $observer) {
                $newObservers[] = $obs;
            }
        }
        $this->observers = $newObservers;
    }
    /**
     * handle observer notify
     */
    function notify()
    {
        foreach ($this->observers as $obs) {
            $obs->update($this);
        }
    }
    /**
     * 执行登陆
     */
    function handleLogin()
    {
        $ip = rand(1,100);
        switch (rand(1, 3)) {
            case 1:
                $this->setStatus(self::LOGIN_ACCESS, $ip);
                $ret = true;
                break;
            case 2:
                $this->setStatus(self::LOGIN_WRONG_PASS, $ip);
                $ret = false;
                break;
            case 3:
                $this->setStatus(self::LOGIN_USER_UNKNOWN, $ip);
                $ret = false;
                break;
        }
        /**
         * handle event
         */
        $this->notify();
        return $ret;
    }
    /**
     * @param $status
     * set login status
     */
    function setStatus($status,$ip)
    {
        $this->status = $status;
        $this->ip = $ip;
    }
    /**
     * @return mixed
     * get login status
     */
    function getStatus()
    {
        return $this->status;
    }
}
/**
 * Interface Observer
 */
interface Observer {
    function update(Observable $observable);
}
/**
 * Class EmailObserver
 */
class EmailObserver implements Observer {
  function update (Observable $observable) {
    $status = $observable->getStatus();
    if($status == Login::LOGIN_ACCESS){
//      $this->sendMail('用户ip:'.$observable->ip.'登陆成功!');
      echo __CLASS__.'用户ip:'.$observable->ip.'登陆成功!'.'----------------'.PHP_EOL;
    }
    if($status == Login::LOGIN_WRONG_PASS){
//      $this->sendMail('用户ip:'.$observable->ip.'登陆失败，密码错误!');
      echo __CLASS__.'用户ip:'.$observable->ip.'登陆失败，密码错误!'.'----------------'.PHP_EOL;
    }
    if($status == Login::LOGIN_USER_UNKNOWN){
//      $this->sendMail('用户ip:'.$observable->ip.'登陆失败，无此用户!');
      echo __CLASS__.'用户ip:'.$observable->ip.'登陆失败，无此用户!'.'----------------'.PHP_EOL;
    }
  }
}
/**
 * Class PhoneObserver
 */
class PhoneObserver implements Observer {
  function update (Observable $observable) {
    $status = $observable->getStatus();
    if($status == Login::LOGIN_ACCESS){
//      $this->sendMail('用户ip:'.$observable->ip.'登陆成功!');
      echo __CLASS__.'用户ip:'.$observable->ip.'登陆成功!'.'----------------'.PHP_EOL;
    }
    if($status == Login::LOGIN_WRONG_PASS){
//      $this->sendMail('用户ip:'.$observable->ip.'登陆失败，密码错误!');
      echo __CLASS__.'用户ip:'.$observable->ip.'登陆失败，密码错误!'.'----------------'.PHP_EOL;
    }
    if($status == Login::LOGIN_USER_UNKNOWN){
//      $this->sendMail('用户ip:'.$observable->ip.'登陆失败，无此用户!');
      echo __CLASS__.'用户ip:'.$observable->ip.'登陆失败，无此用户!'.'----------------'.PHP_EOL;
    }
  }
}
class AbcObserver implements Observer {
  function update (Observable $observable) {
    $status = $observable->getStatus();
    if($status == Login::LOGIN_ACCESS){
//      $this->sendMail('用户ip:'.$observable->ip.'登陆成功!');
      echo __CLASS__.'用户ip:'.$observable->ip.'登陆成功!'.'----------------'.PHP_EOL;
    }
    if($status == Login::LOGIN_WRONG_PASS){
//      $this->sendMail('用户ip:'.$observable->ip.'登陆失败，密码错误!');
      echo __CLASS__.'用户ip:'.$observable->ip.'登陆失败，密码错误!'.'----------------'.PHP_EOL;
    }
    if($status == Login::LOGIN_USER_UNKNOWN){
//      $this->sendMail('用户ip:'.$observable->ip.'登陆失败，无此用户!');
      echo __CLASS__.'用户ip:'.$observable->ip.'登陆失败，无此用户!'.'----------------'.PHP_EOL;
    }
  }
}
//实例化登陆信息
$login = new Login();
//实现发邮件观察者
$login->attach(new EmailObserver());
//实现发验证码观察者
$login->attach(new PhoneObserver());
//实现其他观察者
$login->attach(new AbcObserver());
//开始登陆
$login->handleLogin();
?>