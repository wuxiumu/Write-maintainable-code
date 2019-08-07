<?php
// 桥接模式和装饰模式：

// 这两个模式在一定程度上都可减少子类的数目，避免出现复杂的继承关系，但是它们解决的方法却各有不同，装饰模式吧子类中比基类多出来的部分放到单独的类里面，

// 以适应新功能的添加，把描述新功能的类封装到基类的对象里面时，就得到了所需要的子类对象，这些描述新功能的类通过组合可以实现很多的功能组合。

// 而桥接模式是把两个以上独立的抽象维度分离，使用聚合的方式使其关联，来达到减少子类的目的，结构上桥接模式比装饰模式要复杂。

// 桥接模式和适配器模式

// 它们的共同点是桥接和适配器都是让两个类配合工作，它们的区别是出发点不同，适配器的出发点是改变已有的两个接口，让它们相容，可以结合那些功能上相似但是接口不同的类，

// 桥接模式的出发点是分离抽象化和实现化，是两者的接口可以不同，目的是分离。

//抽象类：电脑
abstract class Computer{
    protected $phone;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }
    public  function &__get($property_name)
    {
        if(isset($this->$property_name))
        {
            return($this->$property_name);
        }
        else
        {
            return(NULL);
        }
    }
    public  function __set($property_name, $value)
    {
        $this->$property_name = $value;
    }
    public abstract function connect();
}
//接口：手机
interface Phone{
    public function connectImpl();
}
//华硕品牌的电脑
class  ASUSComputer extends Computer{
    public function __construct($phone)
    {
        $this->phone=$phone;
    }
    public function connect()
    {
        echo "华硕电脑";
        $this->phone->connectImpl();
    }
}
//戴尔品牌的电脑
class DellComputer extends Computer{
    public function __construct($phone)
    {
        $this->phone=$phone;
    }
    public function connect()
    {
        echo "戴尔电脑";
        $this->phone->connectImpl();
    }

}
//三星手机
class  SamsungPhone implements Phone{
    public function connectImpl()
    {
        echo "连接了三星手机\n";
    }
}
//小米手机
class XiaomiPhone implements Phone{
    public function connectImpl()
    {
        echo "连接了小米手机\n";
    }
}
//抽象类：人
abstract class Person{
    public $computer;
    public function __construct($computer)
    {
        $this->computer = $computer;
    }
    public abstract function useComputer();
}
//学生
class Student extends Person{
    public function useComputer()
    {
        echo "学生使用";
        $this->computer->connect();
    }

}
 //老师
class Teacher extends Person{
    public function useComputer()
    {
        echo "教师使用";
        $this->computer->connect();
    }

}
function main(){
    //华硕电脑连接了小米手机
    $asusComputer=new ASUSComputer(new XiaomiPhone());
    $asusComputer->connect();
    //戴尔电脑连接了三星手机
    $dellComputer=new DellComputer(new SamsungPhone());
    $dellComputer->connect();
    //学生使用华硕电脑连接了小米手机
    $student=new Student(new ASUSComputer(new XiaomiPhone()));
    $student->useComputer();
    //教师使用戴尔电脑连接了三星手机
    $teacher=new Teacher(new DellComputer(new SamsungPhone()));
    $teacher->useComputer();
}
main(); 

// 定义：
// 　　将抽象与实现分离，使它们可以独立变化。它是用组合关系代替继承关系来实现，从而降低了抽象和实现这两个可变维度的耦合度。

//   角色：
// 　　抽象化（Abstraction）角色：定义抽象类，并包含一个对实现化对象的引用。
// 　　扩展抽象化（Refined Abstraction）角色：是抽象化角色的子类，实现父类中的业务方法，并通过组合关系调用实现化角色中的业务方法。
// 　　实现化（Implementor）角色：定义实现化角色的接口，供扩展抽象化角色调用。
// 　　具体实现化（Concrete Implementor）角色：给出实现化角色接口的具体实现。

//   举例：

// 　　车分为很多种（小轿车，公交车），并且每种车都会跑在不同的道路上（街道，高速路），如果使用继承的方式我们可以实现这些场景
// 　　但是那样做的话会使得代码变得可扩展行很差，但是使用桥接模式就不一样啦

// abstract class Road{
//     public $car;
//     public function __construct(Car $car){
//         $this->car = $car;
//     }
//     public abstract function run();
// }

// class SpeedWay extends Road{
//     public function run(){
//         echo $this->car->name." run on SpeedWay\n";
//     }
// }

// class Street extends Road{
//     public function run(){
//         echo $this->car->name." run on Street\n";
//     }
// }

// abstract class Car{
//     public $name;
// }

// class SmallCar extends Car{
//     public function __construct(){
//         $this->name = "SmallCar";
//     }
// }

// class Bus extends Car{
//     public function __construct(){
//         $this->name = "Bus";
//     }
// }

// $small_car = new SmallCar();
// $SpeedWay = new SpeedWay($small_car);
// $SpeedWay->run();

// $bus = new Bus();
// $Street = new Street($bus);
// $Street->run();

// 使用场景：

// 　　当一个类存在两个独立变化的维度，且这两个维度都需要进行扩展时。
// 　　当一个系统不希望使用继承或因为多层次继承导致系统类的个数急剧增加时。
// 　　当一个系统需要在构件的抽象化角色和具体化角色之间增加更多的灵活性时。