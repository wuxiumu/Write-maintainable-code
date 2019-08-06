<?php
/**
 * 创建型模式
 * 工厂方法模式和抽象工厂模式的核心区别
 * 工厂方法模式利用继承，抽象工厂模式利用组合
 * 工厂方法模式产生一个对象，抽象工厂模式产生一族对象
 * 工厂方法模式利用子类创造对象，抽象工厂模式利用接口的实现创造对象
 * 工厂方法模式可以退化为简单工厂模式(非23中GOF)
 */

// 什么是工厂模式
// 就是负责生成其他对象的类或方法
// 为什么需要工厂模式

// 工厂模式可以将对象的生产从直接new 一个对象，改成通过调用一个工厂方法生产。这样的封装，代码若需修改new的对象时，不需修改多处new语句，只需更改生产对象方法。
// 若所需实例化的对象可选择来自不同的类，可省略if-else多层判断，给工厂方法传入对应的参数，利用多态性，实例化对应的类。

 
interface Transport{
    public function go();

}

class Bus implements Transport{
    public function go(){
        echo "bus每一站都要停";
    }
}

class Car implements Transport{
    public function go(){
        echo "car跑的飞快";
    }
}

class Bike implements Transport{
    public function go(){
        echo "bike比较慢";
    }
}

class transFactory{
    public static function factory($transport)
    {
        
        switch ($transport) {
            case 'bus':
                return new Bus();
                break;

            case 'car':
                return new Car();
                break;
            case 'bike':
                return new Bike();
                break;
        }
    }
}

$transport=transFactory::factory('car');
$transport->go();

// 总结:
// 产品改变: 接口不变
// 使用设计模式的一大好处就是可以很容易地对类做出改变, 而不会破坏更大的程序. 之所以能够容易地做出改变, 秘诀在于保持接口不变, 而只改变内容.

// ========================================================================
// 简单代码实现
// //工厂类
// class Factor
// {   
//     // 生成对象方法
//     public static function createDB() 
//     {
//         echo '我生产了一个DB实例';
//         return new DB;
//     }
// }

// //数据类
// class DB
// {
//     public function __construct()
//     {
//         echo __CLASS__ . PHP_EOL;
//     }
// }

// $db = Factor::createDB();
// ========================================================================

// 实现一个运算器
// // 抽象运算类
// abstract class Operation
// {
//     abstract public function getVal($i, $j); // 抽象方法不能包含方法体
// }
// // 加法类
// class OperationAdd extends Operation
// {
//     public function getVal($i, $j)
//     {
//         return $i + $j;
//     }
// }
// // 减法类
// class OperationSub extends Operation
// {
//     public function getVal($i, $j)
//     {
//         return $i - $j;
//     }
// }

// //计数器工厂
// class CounterFactor
// {
//     private static $operation;
//     // 工厂生产特定类对象方法
//     public static function createOperation(string $operation)
//     {
//         switch ($operation) {
//             case '+': self::$operation = new OperationAdd;
//                 break;
//             case '-': self::$operation = new OperationSub;
//                 break;
//         }
//         return self::$operation;
//     }
// }

// $counter = CounterFactor::createOperation('+');
// echo $counter->getVal(1, 2);


// 缺点：若是再增加一个乘法运算，除了增加一个乘法运算类之外，还得去工厂生产方法里面添加对应的case代码，违反了开放-封闭原则。
 
// 解决方法（1）：通过传入指定类名
// // 计算器工厂
// class CounterFactor
// {
//     // 工厂生产特定类对象方法
//     public static function createOperation(string $operation)
//     {
//         return new $operation;
//     }
// }
// class OperationMul extends Operation
// {
//     public function getVal($i, $j)
//     {
//         return $i * $j;
//     }
// }
// $counter = CounterFactor::createOperation('OperationMul');
 

// 解决方法（2）：通过抽象工厂模式
// 这里顺带提一个问题：如果我系统还有个生产一个文本输入器工厂，那么那个工厂和这个计数器工厂又有什么关系呢。

// 抽象高于实现

// 其实我们完全可以抽象出一个抽象工厂，然后将对应的对象生产交给子工厂实现。代码如下：
// // 抽象运算类
// abstract class Operation
// {
//     abstract public function getVal($i, $j); //抽象方法不能包含方法体
// }
// // 加法类
// class OperationAdd extends Operation
// {
//     public function getVal($i, $j)
//     {
//         return $i + $j;
//     }
// }
// // 乘法类
// class OperationMul extends Operation
// {
//     public function getVal($i, $j){
//         return $i * $j;
//     }
// }
// // 抽象工厂类
// abstract class Factor
// {
//     abstract static function getInstance();
// }
// // 加法器生产工厂
// class AddFactor extends Factor
// {
//     // 工厂生产特定类对象方法
//     public static function getInstance()
//     {
//         return new OperationAdd;
//     }
// }
// // 减法器生产工厂
// class MulFactor extends Factor
// {
//     public static function getInstance()
//     {
//         return new OperationMul;
//     }
// }
// // 文本输入器生产工厂
// class TextFactor extends Factor
// {
//     public static function getInstance() {}
// }
// $mul = MulFactor::getInstance();
// echo $mul->getVal(1, 2);
 