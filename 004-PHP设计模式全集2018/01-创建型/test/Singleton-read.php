<?php

class Config1 {}
class Config
{
    // * 必须先声明一个静态私有属性:用来保存当前类的实例
    // * 1. 为什么必须是静态的?因为静态成员属于类,并被类所有实例所共享
    // * 2. 为什么必须是私有的?不允许外部直接访问,仅允许通过类方法控制方法
    // * 3. 为什么要有初始值null,因为类内部访问接口需要检测实例的状态,判断是否需要实例化

    private static $instance = null;
    //保存用户的自定义配置参数
    private $setting = [];
    //构造器私有化:禁止从类外部实例化
    private function __construct(){}
    //克隆方法私有化:禁止从外部克隆对象
    private function __clone(){}
    //因为用静态属性返回类实例,而只能在静态方法使用静态属性
    //所以必须创建一个静态方法来生成当前类的唯一实例
    public static function getInstance()
    {
        //检测当前类属性$instance是否已经保存了当前类的实例
        if (self::$instance == null) {
            //如果没有,则创建当前类的实例
            self::$instance = new self();
        }
        //如果已经有了当前类实例,就直接返回,不要重复创建类实例
        return self::$instance;
    }
    //设置配置项
    public function set($index, $value)
    {
        $this->setting[$index] = $value;
    }
    //读取配置项
    public function get($index)
    {
        return $this->setting[$index];
    }
}
$obj1 = new Config1;
$obj2 = new Config1;
var_dump($obj1,$obj2);
echo '<hr>';
//实例化Config类
$obj1 = Config::getInstance();
$obj2 = Config::getInstance();
var_dump($obj1,$obj2);
$obj1->set('host','localhost');
echo $obj1->get('host');
 
// * 单例模式:一个类仅允许创建一个实例

// 一、什么是单例模式
// 作为对象的创建模式，单例模式确保某一个类只有一个实例，并且对外提供这个全局实例的访问入口。它不会创建实例副本，而是会向单例类内部存储的实例返回一个引用。

// 二、PHP单例模式三要素
// 1. 需要一个保存类的唯一实例的静态成员变量。
// 2. 构造函数和克隆函数必须声明为私有的，防止外部程序创建或复制实例副本。
// 3. 必须提供一个访问这个实例的公共静态方法，从而返回唯一实例的一个引用。

// 三、为什么使用单例模式
// 使用单例模式的好处很大，以数据库操作为例。若不采用单例模式，当程序中出现大量数据库操作时，每次都要执行new操作，
// 每次都会消耗大量的内存资源和系统资源，而且每次打开和关闭数据库连接都是对数据库的一种极大考验和浪费。使用了单例模式，只需要实例化一次，不需要每次都执行new操作，极大降低了资源的耗费。

// 四、单例模式示例
// 这里以数据库操作为例
// class Db
// {
//   //保存全局实例
//   private static $instance;
//   //数据库连接句柄
//   private $db;
//   //数据库连接参数
//   const HOSTNAME = "127.0.0.1";
//   const USERNAME = "root";
//   const PASSWORD = "root";
//   const DBNAME = "testdb";
//   //私有化构造函数，防止外界实例化对象
//   private function __construct()
//   {
//     $this->db = mysqli_connect(self::HOSTNAME,self::USERNAME,
//       self::PASSWORD,self::DBNAME);
//   }
//   //私有化克隆函数，防止外界克隆对象
//   private function __clone()
//   {
//   }
//   //单例访问统一入口
//   public static function getInstance()
//   {
//     if(!(self::$instance instanceof self))
//     {
//       self::$instance = new self();
//     }
//     return self::$instance;
//   }
//   //数据库查询操作
//   public function getinfo()
//   {
//     $sql = "select * from testtb";
//     $res = mysqli_query($this->db,$sql);
//     while($row = mysqli_fetch_array($res)) {
//       echo $row['testcol'] . '<br />';
//     }
//     mysqli_free_result($res);
//   }
// }
// $mysqli = Db::getInstance();
// $mysqli->getinfo();
 