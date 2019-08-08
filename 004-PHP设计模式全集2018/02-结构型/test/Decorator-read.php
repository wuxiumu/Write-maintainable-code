<?php

// 装饰器模式（Decorator Pattern）： 允许向一个已有的对象添加新的功能或部分内容，同时又不改变其结构。
// 属于结构型模式，它是作为现有的类的一个包装。

// （一）为什么需要装饰器模式：

// 1，我们要对一个已有的对象添加新功能，又不想修改它原来的结构。

// 2，使用子类继承的方法去实现添加新功能，会不可避免地出现子类过多，继承链很长的情况。而且不少书籍都规劝我们竭力保持一个对象的父与子关系不超过3个。

// 3，装饰器模式，可以提供对对象内容快速非侵入式地修改。

 

// （三）简单实例

// 如果有一个游戏角色，他原来就是默认穿一件长衫。现在游戏改进了，觉得这个角色，除了穿一件长衫前，还可以在里面穿一件袍子，或是一件球衣。在外面穿一套盔甲或是宇航服。
 
/*游戏原来的角色类
class Person{
    public function clothes(){
        echo "长衫".PHP_EOL;
    }
}
*/

//装饰器接口
interface Decorator
{
   public function beforeDraw();
   public function afterDraw();
}
//具体装饰器1-宇航员装饰
class AstronautDecorator implements Decorator
{
    public function beforeDraw()
    {
        echo "穿上T恤".PHP_EOL;
    }
    function afterDraw()
    {
        echo "穿上宇航服".PHP_EOL;
        echo "穿戴完毕".PHP_EOL;
    }
}
//具体装饰器2-警察装饰
class PoliceDecorator implements Decorator{
    public function beforeDraw()
    {
        echo "穿上警服".PHP_EOL;
    }
    function afterDraw()
    {
        echo "穿上防弹衣".PHP_EOL;
        echo "穿戴完毕".PHP_EOL;
    }
}
//被装饰者
class Person{
    protected $decorators = array(); //存放装饰器
    //添加装饰器
    public function addDecorator(Decorator $decorator)
    {
        $this->decorators[] = $decorator;
    }
    //所有装饰器的穿长衫前方法调用
    public function beforeDraw()
    {
        foreach($this->decorators as $decorator)
        {
            $decorator->beforeDraw();
        }
    }
    //所有装饰器的穿长衫后方法调用
    public function afterDraw()
    {
        $decorators = array_reverse($this->decorators);
        foreach($decorators as $decorator)
        {
            $decorator->afterDraw();
        }
    }
    //装饰方法
    public function clothes(){
        $this->beforeDraw();
        echo "穿上长衫".PHP_EOL;
        $this->afterDraw();
    }
}
//警察装饰
$police = new Person;
$police->addDecorator(new PoliceDecorator);
$police->clothes();
//宇航员装饰
$astronaut = new Person;
$astronaut->addDecorator(new AstronautDecorator);
$astronaut->clothes();
//混搭风
$madman = new Person;
$madman->addDecorator(new PoliceDecorator);
$madman->addDecorator(new AstronautDecorator);
$madman->clothes(); 

// 当然，上面的代码没有严格地按照UML图，这是因为当被装饰者只有一个时，那 Component也就是ConcreteComponent。同理，如果，只有一个装饰器，那也没必要实现一个implment接口。

// 如果我们有两个不同的被装饰者，那当然就应该抽象出一个Component，让这两个被装饰者去继承它。也许，那继承不是又来了吗。既然外面都用到继承，直接把装饰器的方法放到继承里面不就行了。

// 可是你想，如果，直接通过继承的话，那装饰过的被装饰者就应该继承自被装饰者，而且被装饰者因为装饰的不同还要有很多不同类型的子类。而使用装饰者模式的话，继承链缩短了，而且不同的装饰类型还可以动态增加。

// 什么是装饰器模式

// 作为一种结构型模式, 装饰器(Decorator)模式就是对一个已有结构增加"装饰".

// 适配器模式, 是为现在有结构增加的是一个适配器类,.将一个类的接口，转换成客户期望的另外一个接口.适配器让原本接口不兼容的类可以很好的合作.

// 装饰器模式是将一个对象包装起来以增强新的行为和责任.装饰器也称为包装器(类似于适配器)

// 有些设计设计模式包含一个抽象类,而且该抽象类还继承了另一个抽象类,这种设计模式为数不多,而装饰器就是其中之一.

// 什么时候使用装饰器模式

// 基本说来, 如果想为现有对象增加新功能而不想影响其他对象, 就可以使用装饰器模式.
// 如果你好不容易为客户创建了一个网站格式, 主要组件的工作都很完美, 客户请求新功能时, 你肯定不希望推翻重来, 再重新创建网站. 
// 例如, 假设你已经构建了客户原先请求的组件, 之后客户又有了新的需求, 希望在网站中包含视频功能. 
// 你不用重写原先的组件, 只需要"装饰"现有组件, 为它们增加视频功能. 这样即可以保持原来的功能,还可以增加新功能.

// 有些项目可能有时需要装饰, 而有时不希望装饰, 这些项目体现了装饰器设计模式的另一个重要特性.假设你的基本网站开发模式可以满足大多数客户的要求. 
// 不过, 胡些客户还希望有一些特定的功能来满足他们的需求. 并不是所有人都希望或需要这些额外的功能. 作为开发人员, 你希望你创建的网站能满足客户的业务目标. 
// 所以需要提供"本地化"(customerization)特性, 即针对特定业务提供的特性. 利用装饰器模式, 不仅能提供核心功能, 还可以用客户要求的特有功能"装饰"这些核心功能.

// 我们都知道，得到一匹布需要大概这么几步：
//        1、染色
//        2、印花
//        3、裁剪
//   这种形式在面向对象中怎么实现呢？
 
// 面向过程【继承模式】实现：
//     继承模式得到需要的布料，一步一步的加工。 
//     继承的层次越来越深，扩展性差。如果中间加道其他程序，就有些吃力了。
 
// <?php
//     header("content-type:text/html;charset=utf8");
//     class BaseCloth{         //布料初始的样子
//         protected $content;
//         public function __construct($con){
//             $this->content=$con;
//         }
//         public function cloth(){
//             return $this->content;
//         }
//     }
//     class DyeingCloth extends BaseCloth{   //染色
//         public function dyeing(){
//             return $this->content."  --->染上色";
//         }
//     }
//     class StampCloth extends DyeingCloth{   //印花
//         public function stamp(){
//             return $this->content."  --->印上好看的花";
//         }
//     }
//     class CutCloth extends StampCloth{      //裁剪
//         public function cut(){
//             return $this->content."  --->根据需求裁剪";
//         }
//     }



//     //布料加工。
//     $cloth= new BaseCloth("白布");
//     $dyeing=new DyeingCloth($cloth->cloth());
//     $stamp=new StampCloth($dyeing->dyeing());
//     $cut=new CutCloth($stamp->stamp());
//     echo $cut->cut();
//  
 
// 装饰器模式实现布匹加工。

// 
//     header("content-type:text/html;charset=utf8");
//     /**
//      * 装饰器模式完成布料的加工。动态、扩展性好。
//      */
//     class BaseCloth{         //布料的初始样子
//         protected $content;
//         public function __construct($con){
//             $this->content=$con;
//         }
//         public function cloth(){
//             return $this->content;
//         }
//     }
//     class DyeingCloth extends BaseCloth{   //染色
//         public function __construct(BaseCloth $cloth){
//             $this->cloth=$cloth;
//             $this->cloth();
//         }
//         public function cloth(){
//             return $this->cloth->cloth()."  --->染上色";
//         }
//     }
//     class StampCloth extends BaseCloth{   //印花
//         public function __construct(BaseCloth $cloth){
//             $this->cloth=$cloth;
//             $this->cloth();
//         }
//         public function cloth(){
//             return $this->cloth->cloth()."  --->印上花";
//         }
//     }
//     class CutCloth extends BaseCloth{      //裁剪
//         public function __construct(BaseCloth $cloth){
//             $this->cloth=$cloth;
//             $this->cloth();
//         }
//         public function cloth(){
//             return $this->cloth->cloth()."  --->根据需求裁剪";
//         }
//     }


//     //布料加工。
//     $con=new CutCloth(new DyeingCloth(new BaseCloth("白布")));
//     echo $con->cloth();
//  