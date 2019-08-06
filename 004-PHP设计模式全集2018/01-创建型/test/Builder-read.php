<?php
// 1、在客户端看来需要的仅仅是实例化后的类对象（大多数情况下是需要类的属性）。
// 2、传统方式下当类有了之后，一般直接通过new class()的方式直接进行实例化，然后通过$obj->set1()构建属性1，$obj->set2()构建属性2，$obj->set3()构建属性3。。。
// 3、传统方式有一个很大的弊端：当我们的类发生改变后，我们需要大量的修改，比如文件1中加上$obj->set4()，文件2中加上$obj->set4()，增加很多的工作量。
// 4、建造者模式会给出构建对象的具体实现类，将对象的创建实例化过程封装在建造者类中，并给出一个返回构建后对象的方法，将构建后的对象返回。
// 5、当类发生改变后，只需要改变建造者类中构建对象的build()方法，对客户端来说，这并不可见，并且不用做修改就得到了修改后的对象。改动的只是需求对象修改后的逻辑处理。

/**
* 产品类Person
*/
class Person
{
  public $_head;
  public $_body;
  public function setHead($head){
    $this->_head=$head;
  }
  public function getHead(){
    echo $this->_head;
  }
  public function setBody($body){
    $this->_body=$body;
  }
  public function getBody(){
    echo $this->_body;
  }
}
/*
抽象建造者：
定义的一个抽象接口，用于对具体建造者类进行规范
*/
interface Builder{
  public function buildHead();
  public function buildBody();
  public function getResult();
}
/*
具体建造者：
用于实现具体建造者类
*/
class ConcreteBuilder implements Builder{
  public $person;
  public $data;
  public function __construct($data){
    $this->person=new Person();
    $this->data=$data;
  }
  public function buildHead(){
    $this->person->setHead($this->data['head']);
  }
  public function buildBody(){
    $this->person->setBody($this->data['body']);
  }
  public function getResult(){
    return $this->person;
  }
}
/*
导演者类：
用于调用具体建造者类创建产品类实例
*/
class Director{
  public function __construct(ConcreteBuilder $builder){
    $builder->buildHead();
    $builder->buildBody();
  }
}
/*
客户端：
根据需求进行逻辑处理
*/
$data=array(
  'head'=>'漂亮的姐姐😍 ',
  'body'=>' 身才棒棒哒'
  );
$builder=new ConcreteBuilder($data);
$director=new Director($builder);
$person=$builder->getResult();
echo $person->_head;
echo $person->_body;


// 建造者模式中，有如下四个角色：

// Product 产品类
//       通常是实现了模板方法模式，也就是有模板方法和基本方法，这个参考上一章节的模板方法模式。在例子中，BenzModel和BMWModel就属于产品类。

// Builder 抽象建造者
//       规范产品的组建，一般是由子类实现。在例子中，CarBuilder属于抽象建造者。

// ConcreteBuilder 具体建造者
//       实现抽象类定义的所有方法，并且返回一个组件好的对象。在例子中，BenzBuilder和BMWBuilder就属于具体建造者。

// Director 导演
//       负责安排已有模块的顺序，然后告诉Builder开始建造，在上面的例子中就是我们的老大，牛叉公司找到老大，说我要这个，这个，那个类型的车辆模型，然后老大就把命令传递给我，我和我的团队就开始拼命的建造，于是一个项目建设完毕了。

// <?php

// abstract class carModel{

//     //这里存储所有组装车需要的零件
//     public $spareParts = array();

//     //车的名字
//     public $carName = "";

//     //增加轮子部件
//     public abstract function addLunzi($xinghao);

//     //增加外壳部件
//     public abstract function addWaike($xinghao);

//     //增加发动机部件
//     public abstract function addFadongji($xinghao);

//     //获取车，并给车取名字
//     final public function getCar($carName){
//         if($this->spareParts){
//             $this->carName = $carName;
//             //$k 代表部件名字
//             //$v 代表型号
//             foreach($this->spareParts as $k=>$v){
//                 $actionName = "add" . $k;
//                 $this->$actionName($v); 
//             }
//         }else{
//             throw new Exception("没有汽车部件");
            
//         }
//     }
// }


// //定义具体的产品
// class bmwCarModel extends carModel{

//     public $spareParts = array();
//     public $carName = "";

//     public function addLunzi($xinghao){
//         echo "宝马".$this->carName."的轮子，型号是" . $xinghao . "\n";
//     }

//     public function addWaike($xinghao){
//         echo "宝马".$this->carName."的外壳，型号是" . $xinghao . "\n";
//     }

//     public function addFadongji($xinghao){
//         echo "宝马".$this->carName."的发动机,型号是 " . $xinghao . "\n";
//     }
// }


// //定义具体的产品
// class benziCarModel extends carModel{

//     public $spareParts = array();
//     public $carName = "";

//     public function addLunzi($xinghao){
//         echo "奔驰".$this->carName."的轮子，型号是" . $xinghao . "\n";
//     }

//     public function addWaike($xinghao){
//         echo "奔驰".$this->carName."的外壳，型号是" . $xinghao . "\n";
//     }

//     public function addFadongji($xinghao){
//         echo "奔驰".$this->carName."的发动机,型号是 " . $xinghao . "\n";
//     }
// }



// //定义建造者
// abstract class carBuilder{
//     public abstract function setSpareParts($partsName , $xinghao);

//     public abstract function getCarModel($name);
// }


// class bmwBuilder extends carBuilder{
//     private $bmwModel;

//     public function __construct(){
//         $this->bmwModel = new bmwCarModel();
//     }

//     public function setSpareParts($partsName , $xinghao){
//         $this->bmwModel->spareParts[$partsName] = $xinghao;
//     }

//     public function getCarModel($name){
//         $this->bmwModel->getCar($name);
//     }
// }


// class benziBuilder extends carBuilder{
//     private $benziModel;

//     public function __construct(){
//         $this->benziModel = new benziCarModel();
//     }

//     public function setSpareParts($partsName , $xinghao){
//         $this->bmwModel->spareParts[$partsName] = $xinghao;
//     }

//     public function getCarModel($name){
//         $this->bmwModel->getCar($name);
//     }
// }



// //模拟客户端调用

// //创建一辆宝马车，取名字为宝马x1

// $bmwBuilder = new bmwBuilder();
// $bmwBuilder->setSpareParts('Lunzi' , '牛逼轮子1号');
// $bmwBuilder->setSpareParts('Waike' , '牛逼外壳1号');
// $bmwBuilder->setSpareParts('Fadongji' , '牛逼发动机1号');
// $bmwBuilder->getCarModel("宝马x1"); 
// $bmwBuilder->getCarModel("宝马x1");  //连续创建两个宝马x1

// //再创建一个宝马 没有外壳 取名为 宝马s5
// $bmwBuilder = new bmwBuilder();
// $bmwBuilder->setSpareParts('Lunzi' , '牛逼轮子2号');
// $bmwBuilder->setSpareParts('Fadongji' , '牛逼发动机2号');
// $bmwBuilder->getCarModel("宝马s5"); 
// $bmwBuilder->getCarModel("宝马s5");  //连续创建两个宝马x1