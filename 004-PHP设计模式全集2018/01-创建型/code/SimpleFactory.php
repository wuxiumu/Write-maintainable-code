<?php
## 简单的代码说明一下，现在假设我们是顾客，需要苹果味饮料和香蕉味饮料
// class AppleDrink{
//     function getDrinkName()
//     {
//         echo '苹果饮料';
//     }
// }

// class BananaDrink{
//     function getDrinkName()
//     {
//         echo '香蕉饮料';
//     }
// }

// //顾客1
// $apple = new AppleDrink();
// $apple->getDrinkName();
// $banana = new BananaDrink();
// $banana->getDrinkName();

// //顾客2
// $apple1 = new AppleDrink();
// $apple1->getDrinkName();
// $banana1 = new BananaDrink();
// $banana1->getDrinkName(); 

## 用简单工厂模式
// class AppleDrink{
//     function getDrinkName()
//     {
//         echo '苹果饮料';
//     }

// }

// class BananaDrink{
//     function getDrinkName()
//     {
//         echo '香蕉饮料';
//     }

// }

// class FruitFactory{

//     function makeDrink($fruit){
//         if ($fruit == 'apple'){
//             return new AppleDrink();
//         }elseif ($fruit == 'banana'){
//             return new BananaDrink();
//         }
//     }
// }

// $factory = new FruitFactory();
// $apple = $factory->makeDrink('apple');
// $apple->getDrinkName();
// $banana = $factory->makeDrink('banana');
// $banana->getDrinkName();
// $apple1 = $factory->makeDrink('apple');
// $apple1->getDrinkName();
// $banana1 = $factory->makeDrink('banana');
// $banana1->getDrinkName(); 

// 这就是简单工厂模式，用户在使用时可以直接根据工厂类去创建所需的实例，
// 而无需了解这些对象是如何创建以及如何组织的，外界与具体类隔离开来，
// 耦合性低，有利于整个软件体系结构的优化，适用于工厂类负责创建的对象比较少，客户只知道传入了工厂类的参数，
// 对于如何创建对象（逻辑）不关心，简单工厂模式又叫静态工厂模式 可以把工厂类的方法写成静态方法 在不需要实例化工厂的前提下 直接调用静态方法 返回所需实例
 
// class OrangeDrink{
//     function getDrinkName()
//     {
//         echo '桔子味饮料';
//     }
// }

// class FruitFactory{

//     function makeDrink($fruit){
//         if ($fruit == 'apple'){
//             return new AppleDrink();
//         }elseif ($fruit == 'banana'){
//             return new BananaDrink();
//         }elseif ($fruit == 'orange'){
//             return new OrangeDrink();
//         }
//     }
// } 

//再改写一下这个方法
interface Drink{
    function getDrinkName();
}

class AppleDrink implements Drink{
    function getDrinkName()
    {
        echo '苹果味饮料';
    }
}

class BananaDrink implements Drink{
    function getDrinkName()
    {
        echo '香蕉味饮料';
    }
}


interface FruitFactory{
    function makeDrink();
}

class AppleFactory implements FruitFactory{
    function makeDrink()
    {
        return new AppleDrink();
    }
}

class BananaFactory implements FruitFactory{
    function makeDrink()
    {
        return new BananaDrink();
    }
}

$appleFactory = new AppleFactory();
$apple = $appleFactory->makeDrink();
$apple->getDrinkName();

$bananaFactory = new BananaFactory();
$banana = $bananaFactory->makeDrink();
$banana->getDrinkName();

//现在当再次需要增加桔子味饮料时，只需要增加桔子味饮料产品和桔子味饮料工厂即可，不需要改动原来的代码

// class OrangeDrink implements Drink{
//     function getDrinkName()
//     {
//         echo '桔子味饮料';
//     }
// }
// class OrangeFactory implements FruitFactory{
//     function makeDrink()
//     {
//         return new OrangeDrink();
//     }
// } 