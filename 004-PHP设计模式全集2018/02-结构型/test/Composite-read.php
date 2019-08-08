<?php 
/** 
* 组合模式 
* 
* 将对象组合成树形结构以表示"部分-整体"的层次结构,使得客户对单个对象和复合对象的使用具有一致性 
*/ 
// abstract class MenuComponent 
// { 
// public function add($component){} 
// public function remove($component){} 
// public function getName(){} 
// public function getUrl(){} 
// public function display(){} 
// } 
// class Menu extends MenuComponent 
// { 
// private $_items = array(); 
// private $_name = null; 
// public function __construct($name) 
// { 
// $this->_name = $name; 
// } 
// public function add($component) 
// { 
// $this->_items[] = $component; 
// } 
// public function remove($component) 
// { 
// $key = array_search($component,$this->_items); 
// if($key !== false) unset($this->_items[$key]); 
// } 
// public function display() 
// { 
// echo "-- ".$this->_name." ---------<br/>"; 
// foreach($this->_items as $item) 
// { 
// $item->display(); 
// } 
// } 
// } 
// class Item extends MenuComponent 
// { 
// private $_name = null; 
// private $_url = null; 
// public function __construct($name,$url) 
// { 
// $this->_name = $name; 
// $this->_url = $url; 
// } 
// public function display() 
// { 
// echo $this->_name."#".$this->_url."<br/>"; 
// } 
// } 
// class Client 
// { 
// private $_menu = null; 
// public function __construct($menu) 
// { 
// $this->_menu = $menu; 
// } 
// public function setMenu($menu) 
// { 
// $this->_menu = $menu; 
// } 
// public function displayMenu() 
// { 
// $this->_menu->display(); 
// } 
// } 
// // 实例一下 
// // 创建menu 
// $subMenu1 = new Menu("sub menu1"); 
// $subMenu2 = new Menu("sub menu2"); 
// $subMenu3 = new Menu("sub menu3"); 
// $item1 = new Item("163","www.163.com"); 
// $item2 = new Item("sina","www.sina.com"); 
// $subMenu1->add($item1); 
// $subMenu1->add($item2); 
// $item3 = new Item("baidu","www.baidu.com"); 
// $item4 = new Item("google","www.google.com"); 
// $subMenu2->add($item3); 
// $subMenu2->add($item4); 
// $allMenu = new Menu("All Menu"); 
// $allMenu->add($subMenu1); 
// $allMenu->add($subMenu2); 
// $allMenu->add($subMenu3); 
// $objClient = new Client($allMenu); 
// $objClient->displayMenu(); 
// $objClient->setMenu($subMenu2); 
// $objClient->displayMenu(); 

// 组合模式 (Composite Pattern)
// 组合模式：允许客户将对象组合成树形结构来表现"整体/部分”层次结构。组合能让客户以一致的方式处理个别对象以及对象组合。

// 组合模式让我们能用树形方式创建对象的结构，树里面包含了组合以及个别的对象。

// 使用组合结构，我们能把相同的操作应用在组合和个别对象上。换句话说，在大多数情况下，我们可以忽略对象组合和个别对象之间的差别。

// 包含其他组件的组件为组合对象；不包含其他组件的组件为叶节点对象。

// 组合模式为了保持”透明性“，常常会违反单一责任原则。也就是说，它一方面要管理内部对象，另一方面要提供一套访问接口。

// 当组合模式接口里提供删除子节点的方法时，在组件里有一个指向父节点的指针的话，实现删除操作会比较容易。

// 以一个军队的战斗力计算为例演示组合模式

// 军队由步兵、炮兵、特种兵组成，他们都具备一个能力就是战斗并具备各自的战斗力。我们通过他们组合成一个军队并完成战斗力的计算。

 

//抽象士兵类

interface soldier{

public function fire();

}

//步兵 攻击力5

class bubing implements soldier{

public function fire(){

return 5;

}

}

//炮兵 攻击力8

class paobing implements soldier{

public function fire(){

return 8;

}

}

//特种兵 攻击力 12

class tezhongbing implements soldier{

public function fire(){

return 12;

}

}

//军队类实现兵种的组合

class arm{

//存储作战兵种的数组 

private $soldier = array();

//添加作战兵种

public function add($soldierType){

//获取对应的兵种对象

$soldier  = new $soldierType();

//保存进数组利用数组的键记录兵种 便于删除

$this->soldier[$soldierType] = $soldier;

}

//删除兵种

public function delete($soldierType){

if(isset($this->soldier[$soldierType])){

unset($this->soldier[$soldierType]);

}

}

//计算并输出战斗能力

public function show(){

$zhantouli = 0;

foreach($this->soldier as $v){

$zhantouli += $v->fire();

}

echo "军队的战斗力: ".$zhantouli;

}

}

$arm = new arm();

$arm->add('bubing');

$arm->add('paobing');

$arm->show();

$arm->delete('paobing');

$arm->show();

// 1 模式介绍
// 　将对象组合成树形结构以表示“部分-整体”的层次结构，组合模式使得用户对单个对象和组合对象的使用具有一致性。


// 2 模式中的角色
//    1.Component 是组合中的对象声明接口，在适当的情况下，实现所有类共有接口的默认行为。声明一个接口用于访问和管理Component子部件。
//    2.Leaf 在组合中表示叶子结点对象，叶子结点没有子结点。
//    3.Composite 定义有枝节点行为，用来存储子部件，在Component接口中实现与子部件有关操作，如增加(add)和删除(remove)等。 
 
 
// abstract class Component
// {
//     protected $id;
//     protected $name;
 
//     public function __construct($id,$name)
//     {
//         $this->id = $id;
//         $this->name = $name;
//     }
 
//     abstract public function add(Component $c); 
//     abstract public function remove(Component $c); 
//     abstract public function display($depth); 
// }
 
// class Composite extends Component
// {
//     private $children = array();
 
//     public function add(Component $c) 
//     {
//         $this->children[$c->id] = $c;
//     }
 
//     public function remove(Component $c) 
//     {
//         unset($this->children[$c->id]);
//     }
 
//     public function display($depth) 
//     {
//         $str = str_pad('', $depth , "_");
 
//         echo "{$str} {$this->name}\r\n";
 
//         foreach($this->children as $c)
//         {
//             $c->display($depth+2);
//         }
//     }
// }
 
// class Leaf extends Component
// {
//     private $children = array();
 
//     public function add(Component $c) 
//     {
//         echo "can not add to a leaf\r\n";
//     }
 
//     public function remove(Component $c) 
//     {
//         echo "can not remove to a leaf\r\n";
//     }
 
//     public function display($depth) 
//     {
//         $str = str_pad('', $depth , "_");
 
//         echo "{$str} {$this->name}\r\n";
 
//     }
// }
 
// class Client
// {
//     public static function main($argv)    
//     {
//        $root = new Composite(1,'root'); 
//        $root->add(new Leaf(2,'leaf 2'));
//        $root->add(new Leaf(3,'leaf 3'));
 
//        $com1 = new Composite(4,'com1'); 
//        $com1->add(new Leaf(5,'com1 leaf 1'));
//        $com1->add(new Leaf(6,'com1 leaf 2'));
 
//        $root->add($com1);
 
//        $root->display(1);
       
//     }
// }
 
// Client::main($argv);
 
 