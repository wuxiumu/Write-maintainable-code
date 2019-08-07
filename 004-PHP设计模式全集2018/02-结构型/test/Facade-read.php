<?php
// 为子系统中的一组接口提供一个一致的界面，定义一个高层接口，这个接口使得这一子系统更加容易使用，外观模式又称门面模式
// 使用外观模式的原因：
// 1,开发阶段，子系统越来越复杂，增加外观模式提供一个简单的调用接口。
// 2,维护一个大型遗留系统的时候，可能这个系统已经非常难以维护和扩展，但又包含非常重要的功能，为其开发一个外观类，以便新系统与其交互。
// 3,外观模式可以隐藏来自调用对象的复杂性。


// 外观模式的目的在于降低系统的复杂程度
 

 
// 外观模式(Facade Pattern)：外部与一个子系统的通信必须通过一个统一的外观对象进行，为子系统中的一组接口提供一个一致的界面，外观模式定义了一个高层接口，这个接口使得这一子系统更加容易使用。外观模式又称为门面模式，它是一种对象结构型模式。

// 模式结构
// 外观模式包含如下角色：
// Facade: 外观角色
// SubSystem:子系统角色 

//SubSystem:子系统角色
class SubSystemOne
{
    public function MethodOne(){
        var_dump('子系统方法一');
    }
}
class SubSystemTwo
{
    public function MethodTwo(){
        var_dump('子系统方法二');
    }
}
class SubSystemThree
{
    public function MethodThree(){
        var_dump('子系统方法三');
    }
}
class SubSystemFour
{
    public function MethodFour(){
        var_dump('子系统方法四');
    }
}

//Facade: 外观角色
class Facade
{
    public function __construct(){
        $this->one=new SubSystemOne();
        $this->two=new SubSystemTwo();
        $this->three=new SubSystemThree();
        $this->four=new SubSystemFour();
    }
    public function MethodA(){
        var_dump('方法组A');
        $this->one->MethodOne();
        $this->two->MethodTwo();
    }
    public function MethodB(){
        var_dump('方法组B');
        $this->three->MethodThree();
        $this->four->MethodFour();
    }
}

$a=new Facade();
$a->MethodA();
$a->MethodB();

// 关于facade这个词的翻译
// facade这个词，原意指的是一个建筑物的表面、外观，在建筑学中被翻译为“立面”这个术语，国内对facade这个词的关注，可能更多要依赖于laravel的流行，似乎都一致把laravel里的facade翻译作“门面”。说实在的，当第一次看到翻译文档里提什么“门面”的时候，我想你跟我的内心一样：“这是在说什么玩意呢？你是在讲商店、店铺的门面吗？”直到现在，如果非得用中文说facade，非得用“门面”这个词，我的心里还是不自觉地会“咯噔”那么一下，我知道这里是有问题的。

// facade到底翻译作啥好呢？倒是也有的人群干脆提倡不翻译，遇到它就直接英文单词拿过来，这也不是个长远办法，终归是要为了新入门的人铺平理解的道路才好。后来偶然看到台湾的学者，确切说是台湾的维基百科，将facade pattern译作“外观模式”，考虑到该模式的实际作用，方才感觉瞬间释然。即使laravel里的facade，严格上并不是facade pattern，很多人到现在依然在批评laravel在facade这个词语上的滥用和误导，但它终归也是在借用或模仿facade pattern，所以laravel里的facade，本文也认为同样翻译成“外观”比较好，当然，为了更好理解，可以是“服务外观”。即使如此，从私人角度，我更希望将其直呼为“服务定位器”、“服务代理”或者“服务别名”，实际上国外的很多人也是建议如此更名，只是Taylor在这件事上态度一反往常地强硬，所以也暂且不必强求。

// 通过下文，待实际了解了facade pattern具体是啥后，我想你会更好地理解为什么翻译为“外观模式”更贴切。

// 什么是facade pattern（“外观模式”的定义）
// 不论在现实世界还是编程世界，facade（外观）的目的就是给一个可能原本丑的、杂乱的东西，“披上”一个优美的、吸引人的外观、或者说面具，用中国的俗话就是：什么是外观？“人靠衣装马靠鞍”。基于此，facade pattern就是将一个或多个杂乱的、复杂的、不容易重构的class，添加上（或转换成）一个漂亮优雅的对接入口（interface），这样呢好让你更乐意、更方便地去操作它，从而间接地操作了背后的实际逻辑。

// 什么时候需要用facade pattern
// facade pattern（“外观模式”）经常是用来给一个或多个子系统，来提供统一的入口界面（interface），或者说操作界面。
// 当你需要操作别人遗留下来的项目，或者说第三方的代码的时候。尤其是通常情况下，这些代码你不容易去重构它们，也没有提供测试（tests）。这个时候，你就可以创建一个facade(“外观”),去将原来的代码“包裹”起来，以此来简化或优化其使用场景。

 
// header("content-type:text/html;charset=utf-8");
// // ==================php  门面模式(外观模式)  =============================
//  /* 其实门面模式就是把几个子系统(实例或者类.统一一个统一的接口进行执行,客户端不用关注子系统,只用门面即可 )*/
 
// // 门面抽象接口 
// interface Facade{   
//     public function turnOn() ;
//     public function turnOff() ;
// }
 
// // (1) 关闭显示器
// class PcLight {
//     public function turnOn() {}
//     public function turnOff() {
//         echo 'turn off PcLight <br>' ;
//     }   
// }
 
// //(2) pc 机器
// class Pcmachine {
//     public function turnOn() {} 
//     public function turnOff() {
//         echo 'turn off PcMathion <br>' ;
//     }
// }
 
// // (3) 关闭电源
// class Power {
//     public function turnOn() {} 
//     public function turnOff() {
//         echo 'turn off Power <br>' ;
//     }
// }
 
// // 关机的门面角色 
// class PcFacade implements Facade{
     
//     private  $PcLight ; 
//     private  $Pcmachine ; 
//     private  $Power ; 
  
//     public function __construct(){
//      $this->PcLight = new PcLight();
//          $this->Pcmachine = new Pcmachine();
//          $this->Power = new Power();
//     }
     
//     // 门面角色的应用
//      public function turnOff() { 
//           $this->PcLight ->turnOff();
//           $this->Pcmachine ->turnOff();
//           $this->Power ->turnOff();
//      }
//       public function turnOn() {}
// }
 
// // 应用
// $button = new PcFacade(); 
// $button ->turnOff(); 