<?php
// 在这个有没有对象都要高呼“面向对象”的年代，掌握面向对象会给我们带来意想不到的方便。
// 学编程的小伙伴从开始能写几行代码实现简单功能到后来懂得将一些重复的操作组合起来形成一个“函数”，
// 再到后来将“函数”和属性组合起来形成一个“类”。一步步走来，
// 我们在考虑着机器运行代码效率的提高的同时也在考虑减轻程序员的工作量。 
// 那么我们今天讲到的适配器模型更着重考虑的是什么呢？是程序员工作量。
// 　　什么时候会用到适配器模式？
// 　　其实最简单的例子是当我们引用一个第三方类库。这个类库随着版本的改变，它提供的API也可能会改变。
//     如果很不幸的是，你的应用里引用的某个API已经发生改变的时候，除了在心中默默地骂“wocao”之外，
//     你还得去硬着头皮去改大量的代码。 
// 　　难道真的一定要如此吗？按照套路来说，我会回答“不是的”。我们有适配器模式啊~~  
// 　　当接口发生改变时，适配器模式就派上了用场。
// 举个栗子
// 　　如果通过上面的简单描述，你都能懂，那在下只能佩服你的领悟能力超群了。
//     一般人一定还是不知所云。为了方便理解，我引用一位博友的例子。原文地址。
// 　　一开始的和谐
// 　　黑枣玩具公司专门生产玩具，生产的玩具不限于狗、猫、狮子，鱼等动物。
//     每个玩具都可以进行“张嘴”与“闭嘴”操作，分别调用了openMouth与closeMouth方法。
// 　　在这个时候，我们很容易想到可以第一定义一个抽象类Toy,甚至是接口Toy,这些问题不大，
//     其他的类去继承父类，实现父类的方法。一片和谐，信心向荣。
// 　　平衡的破坏
//      为了扩大业务，现在黑枣玩具公司与红枣遥控公司合作，红枣遥控公司可以使用遥控设备对动物进行嘴巴控制。
//      不过红枣遥控公司的遥控设备是调用的动物的doMouthOpen及doMouthClose方法。
//       黑枣玩具公司的程序员现在必须要做的是对Toy系列类进行升级改造，
//       使Toy能调用doMouthOpen及doMouthClose方法。
// 　　考虑实现的方法时，我们很直接地想到，你需要的话我再在我的父类子类里给你添加这么两个方法就好啦。
//     当你一次又一次在父类子类里面重复添加着这两个方法的时候，总会想着如此重复的工作，难道不能解决么？
//     当有数百个子类的时候，程序员会改疯的。程序员往往比的是谁在不影响效率的时候更会“偷懒”。
//    这样做下去程序员会觉得自己很傻。(其实我经常当这样的傻子)

abstract class Toy  
{  
    public abstract function openMouth();  
  
    public abstract function closeMouth();  
}  
  
class Dog extends Toy  
{  
    public function openMouth()  
    {  
        echo "Dog open Mouth\n";  
    }  
  
    public function closeMouth()  
    {  
        echo "Dog close Mouth\n";  
    }  
}  
  
class Cat extends Toy  
{  
    public function openMouth()  
    {  
        echo "Cat open Mouth\n";  
    }  
  
    public function closeMouth()  
    {  
        echo "Cat close Mouth\n";  
    }  
}


//目标角色:红枣遥控公司  
interface RedTarget  
{  
    public function doMouthOpen();  
  
    public function doMouthClose();  
}  
  
//目标角色:绿枣遥控公司及  
interface GreenTarget  
{  
    public function operateMouth($type = 0);  
}


//类适配器角色:红枣遥控公司  
class RedAdapter implements RedTarget  
{  
    private $adaptee;  
  
    function __construct(Toy $adaptee)  
    {  
        $this->adaptee = $adaptee;  
    }  
  
    //委派调用Adaptee的sampleMethod1方法  
    public function doMouthOpen()  
    {  
        $this->adaptee->openMouth();  
    }  
  
    public function doMouthClose()  
    {  
        $this->adaptee->closeMouth();  
    }  
}  
  
//类适配器角色:绿枣遥控公司  
class GreenAdapter implements GreenTarget  
{  
    private $adaptee;  
  
    function __construct(Toy $adaptee)  
    {  
        $this->adaptee = $adaptee;  
    }  
  
    //委派调用Adaptee：GreenTarget的operateMouth方法  
    public function operateMouth($type = 0)  
    {  
        if ($type) {  
            $this->adaptee->openMouth();  
        } else {  
            $this->adaptee->closeMouth();  
        }  
    }  
}



class testDriver  
{  
    public function run()  
    {  
         //实例化一只狗玩具  
        $adaptee_dog = new Dog();  
        echo "给狗套上红枣适配器\n";  
        $adapter_red = new RedAdapter($adaptee_dog);  
        //张嘴  
        $adapter_red->doMouthOpen();  
        //闭嘴  
        $adapter_red->doMouthClose();  
        echo "给狗套上绿枣适配器\n";  
        $adapter_green = new GreenAdapter($adaptee_dog);  
        //张嘴  
        $adapter_green->operateMouth(1);  
        //闭嘴  
        $adapter_green->operateMouth(0);  
    }  
}  
  
$test = new testDriver();  
$test->run();

// 　最后的结果就是，Toy类及其子类在不改变自身的情况下，通过适配器实现了不同的接口。
// 　　最后总结
// 　　将一个类的接口转换成客户希望的另外一个接口,使用原本不兼容的而不能在一起工作的那些类可以在一起工作.
// 　　适配器模式核心思想：把对某些相似的类的操作转化为一个统一的“接口”(这里是比喻的说话)--适配器，
//     或者比喻为一个“界面”，统一或屏蔽了那些类的细节。适配器模式还构造了一种“机制”，
//     使“适配”的类可以很容易的增减，而不用修改与适配器交互的代码，符合“减少代码间耦合”的设计原则。

// 一、意图
// 将一个类的接口转换成客户希望的另外一个接口。Adapter模式使得原来由于接口不兼容而不能一起工作的那此类可以一起工作
// 二、适配器模式结构图
// 三、适配器模式中主要角色
// 目标(Target)角色：定义客户端使用的与特定领域相关的接口，这也就是我们所期待得到的
// 源(Adaptee)角色：需要进行适配的接口
// 适配器(Adapter)角色：对Adaptee的接口与Target接口进行适配；适配器是本模式的核心，适配器把源接口转换成目标接口，此角色为具体类
// 四、适配器模式适用场景
// 1、你想使用一个已经存在的类，而它的接口不符合你的需求
// 2、你想创建一个可以复用的类，该类可以与其他不相关的类或不可预见的类协同工作
// 3、你想使用一个已经存在的子类，但是不可能对每一个都进行子类化以匹配它们的接口。对象适配器可以适配它的父类接口（仅限于对象适配器）
// 五、类适配器模式与对象适配器
// 类适配器：Adapter与Adaptee是继承关系
// 1、用一个具体的Adapter类和Target进行匹配。结果是当我们想要一个匹配一个类以及所有它的子类时，类Adapter将不能胜任工作
// 2、使得Adapter可以重定义Adaptee的部分行为，因为Adapter是Adaptee的一个子集
// 3、仅仅引入一个对象，并不需要额外的指针以间接取得adaptee
// 对象适配器：Adapter与Adaptee是委托关系
// 1、允许一个Adapter与多个Adaptee同时工作。Adapter也可以一次给所有的Adaptee添加功能
// 2、使用重定义Adaptee的行为比较困难
// 适配器模式与其它模式
// 桥梁模式(bridge模式)：桥梁模式与对象适配器类似，但是桥梁模式的出发点不同：桥梁模式目的是将接口部分和实现部分分离，从而对它们可以较为容易也相对独立的加以改变。而对象适配器模式则意味着改变一个已有对象的接口
// 装饰器模式(decorator模式)：装饰模式增强了其他对象的功能而同时又不改变它的接口。因此装饰模式对应用的透明性比适配器更好。
// 六、类适配器模式PHP示例
// 类适配器使用的是继承
// <?php
// /**
//  * 目标角色
//  */
// interface Target {
  
//   /**
//    * 源类也有的方法1
//    */
//   public function sampleMethod1();
  
//   /**
//    * 源类没有的方法2
//    */
//   public function sampleMethod2();
// }
  
// /**
//  * 源角色
//  */
// class Adaptee {
  
//   /**
//    * 源类含有的方法
//    */
//   public function sampleMethod1() {
//     echo 'Adaptee sampleMethod1 <br />';
//   }
// }
  
// /**
//  * 类适配器角色
//  */
// class Adapter extends Adaptee implements Target {
  
//   /**
//    * 源类中没有sampleMethod2方法，在此补充
//    */
//   public function sampleMethod2() {
//     echo 'Adapter sampleMethod2 <br />';
//   }
  
// }
  
// class Client {
  
//   /**
//    * Main program.
//    */
//   public static function main() {
//     $adapter = new Adapter();
//     $adapter->sampleMethod1();
//     $adapter->sampleMethod2();
  
//   }
  
// }
  
// Client::main();
 
// 七、对象适配器模式PHP示例
// 对象适配器使用的是委派 
// <?php
// /**
//  * 目标角色
//  */
// interface Target {
  
//   /**
//    * 源类也有的方法1
//    */
//   public function sampleMethod1();
  
//   /**
//    * 源类没有的方法2
//    */
//   public function sampleMethod2();
// }
  
// /**
//  * 源角色
//  */
// class Adaptee {
  
//   /**
//    * 源类含有的方法
//    */
//   public function sampleMethod1() {
//     echo 'Adaptee sampleMethod1 <br />';
//   }
// }
  
// /**
//  * 类适配器角色
//  */
// class Adapter implements Target {
  
//   private $_adaptee;
  
//   public function __construct(Adaptee $adaptee) {
//     $this->_adaptee = $adaptee;
//   }
  
//   /**
//    * 委派调用Adaptee的sampleMethod1方法
//    */
//   public function sampleMethod1() {
//     $this->_adaptee->sampleMethod1();
//   }
  
//   /**
//    * 源类中没有sampleMethod2方法，在此补充
//    */
//   public function sampleMethod2() {
//     echo 'Adapter sampleMethod2 <br />';
//   }
  
// }
  
// class Client {
  
//   /**
//    * Main program.
//    */
//   public static function main() {
//     $adaptee = new Adaptee();
//     $adapter = new Adapter($adaptee);
//     $adapter->sampleMethod1();
//     $adapter->sampleMethod2();
  
//   }
  
// }
  
// Client::main();
// ?>
