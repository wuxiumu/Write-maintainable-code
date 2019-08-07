<?php  
//   享元模式（Flyweight）属于结构型模式之一，定义：运用共享技术有效地支持大量细粒度对象的复用。
//   看定义理解起来也不算难，就是将系统中需要重复创建的对象，共享在一个享元池里面，
//   当第二次创建的时候，直接调用享元池里面已经存好的对象就可以了。
//   主要用于大量需要重复创建的对象。
//   整体代码的结构有点像是简单工厂扩展演变而来的，在简单工厂的基础上，把重复创建的对象共享在享元池。
 
//   场景：
//   我们在玩一些战争类游戏的时候，我们经常会在兵工厂里面重复去购买各种兵种的士兵，每个士兵都是对象的话，我们就会需要重复创建很多对象，享元模式很好的帮我们解决了这个问题。
/** 抽象兵工厂类      
 *  abstract Arsenal          
 */    
abstract Class Arsenal{  
  abstract function Create();  
}  
  
  
/** 具体战士类      
 *  Warrior        
 */    
Class Warrior extends Arsenal  
{  
   function Create()  
   {  
        echo "战士：保家卫国！冲啊<br/>";  
   }  
}  
  
/** 具体骑士类      
 *  Knight        
 */  
Class Knight extends Arsenal   
{  
   function Create()  
   {  
        echo "骑士：冲散敌军阵形<br/>";  
   }      
}  
  
/** 享元类      
 *  Flyweight        
 */  
Class Flyweight{  
  // 定义享元池  
    private $flyweights = array();  
  
    function getObjClass($name){  
  
        if(isset($this->flyweights[$name]))  
        {  
            echo "*************从享元池里取出************<br/>";  
          return $this->flyweights[$name];  
        }  
        else{  
          echo "*************新建对象并存入享元池************<br/>";  
          $ClassName = new $name();  
          $this->flyweights[$name] = $ClassName;  
          return $this->flyweights[$name];  
        }  
    }  
  
} 

 
header("Content-Type:text/html;charset=utf-8");    
  
// require_once "Flyweight.php";    
  
$obj = new Flyweight();  
// 第1个战士  
$War1 = $obj->getObjClass("Warrior");   
$War1->Create();  
  
// 第2个战士  
$War2 = $obj->getObjClass("Warrior");   
$War2->Create();  
  
// 第3个战士  
$War3 = $obj->getObjClass("Warrior");   
$War3->Create();  
  
  
// 第1个骑兵  
$kni1 = $obj->getObjClass("Knight");   
$kni1->Create();  
  
// 第2个骑兵  
$kni2 = $obj->getObjClass("Knight");   
$kni2->Create();

// 享元模式使用共享物件，用来尽可能减少内存使用量以及分享资讯给尽可能多的相似物件；
// 它适合用于只是因重复而导致使用无法令人接受的大量内存的大量物件。
// 通常物件中的部分状态是可以分享。常见做法是把它们放在外部数据结构，当需要使用时再将它们传递给享元。

//   优点：

//         1.减少运行时对象实例的个数，节省内存

//         2.将许多“虚拟”对象的状态集中管理

//         缺点：

//          一旦被实现，单个的逻辑实现将无法拥有独立而不同的行为

//  

//          适用场景：

//           当一个类有许多的实例，而这些实例能被同一方法控制的时候，我们就可以使用享元模式。 

// interface Shape{
//     public function draw();
// }

// class Circle implements Shape {
//     private $color;
//     private $radius;
    
//     public function __construct($color) {
//         $this->color = $color;
//     }
    
//     public function draw() {
//         echo sprintf('Color %s, radius %s <br/>', $this->color,
//             $this->radius);
//     }
    
//     public function setRadius($radius) {
//         $this->radius = $radius;
//     }
// }

// class ShapeFactory {
//     private $circleMap;
    
//     public function getCircle($color) {
//         if (!isset($this->cicrleMap[$color])) {
//             $circle = new Circle($color);
//             $this->circleMap[$color] = $circle;
//         }
//         return $this->circleMap[$color];
//     }
// }

// $shapeFactory = new ShapeFactory();
// $circle = $shapeFactory->getCircle('yellow');
// $circle->setRadius(10);
// $circle->draw();

// $shapeFactory = new ShapeFactory();
// $circle = $shapeFactory->getCircle('orange');
// $circle->setRadius(15);
// $circle->draw();

// $shapeFactory = new ShapeFactory();
// $circle = $shapeFactory->getCircle('yellow');
// $circle->setRadius(20);
// $circle->draw();
// 