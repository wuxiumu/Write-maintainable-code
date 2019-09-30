<?php
//Registry.class.php
/** 
 * 注册器读写类 
 */
class Registry extends ArrayObject
{
  /** 
   * Registry实例
   *
   * @var object 
   */
  private static $_instance = null;
  /**
   * 取得Registry实例
   * 
   * @note 单件模式
   * 
   * @return object
   */
  public static function getInstance()
  {
    if (self::$_instance === null) {
      self::$_instance = new self();
      echo "new register object!";
    }
    return self::$_instance;
  }
  /**
   * 保存一项内容到注册表中
   * 
   * @param string $name 索引
   * @param mixed $value 数据
   * 
   * @return void
   */
  public static function set($name, $value)
  {
    self::getInstance()->offsetSet($name, $value);
  }
  /**
   * 取得注册表中某项内容的值
   * 
   * @param string $name 索引
   * 
   * @return mixed
   */
  public static function get($name)
  {
    $instance = self::getInstance();
    if (!$instance->offsetExists($name)) {
      return null;
    }
    return $instance->offsetGet($name);
  }
  /**
   * 检查一个索引是否存在 
   * 
   * @param string $name 索引
   * 
   * @return boolean
   */
  public static function isRegistered($name)
  {
    return self::getInstance()->offsetExists($name);
  }
  /**
   * 删除注册表中的指定项
   * 
   * @param string $name 索引
   * 
   * @return void
   */
  public static function remove($name)
  {
    self::getInstance()->offsetUnset($name);
  }
}

//test.class.php
class Test
{
   function hello()
   {
    echo "hello world";
    return;
   }
} 

//引入相关类
// require_once "Registry.class.php";
// require_once "test.class.php";
//new a object
$test = new Test();
//$test->hello();
//注册对象
Registry::set('testclass',$test);
//取出对象
$t = Registry::get('testclass');
//调用对象方法
$t->hello();