<?php
 
//  平行继承层次的出现是工厂方法模式带来的一个问题。这是一种让一些程序员不舒服的耦
// 合。每次添加产品家族时,你就被迫去创建一个相关的具体创建者。在一个快速增长的系统里会包含越来越多的产品,而维护这种关系便
// 会很快令人厌烦。
// 个避免这种依赖的办法是使用PHP的 clone关键词复制已存在的具体产品,然后,具体产品类本身便成为它们自己生成的基础。
//这使是原型模式。使用该模式我们可以用组合代替继承。这样的转变则促进了代码运行时的灵活性,并减少了必须创建的类的数量

//     假设有一款“文明”( Civilization)风格的网络游戏,可在区块组成的格子中操作战斗单元(unit)。每个区块分别代表海洋、平原和森林。
// 地形的类别约束了占有区块的单元的格斗能力。我们可以有一个 errainFactory对象来提供Sea、 Forest和 Plains.对象,我们决定允许用户在完全不同的环境里选择,
//于是Sea可能是 Marssea和 Earthsea的抽象父类。 Forest(森林)和P1ains(平原)对象也会有相似的实现。这里的分支便构成了抽象工厂模式。
//我们有截然不同的产品体系(Sea、 Plains、 Forests),而这些产品家族间有超越继承的紧密联系,如 Earth(地球)和Mars(火星),它们都同时存在海洋、森林和平原地形。
// 
//     
// 你可以看到,我们依赖继承来组合工厂生成的 terrain(地形)家族产品,这的确是一个可行的解决方案,但这需要有一个大型的继承体系,并且相对来说不那么灵活。
// 当你不想要平行的集成体系而需要最大化运行时的灵活性时,可以使用抽象工厂模式的强大变形一原型模式

//海洋
class Sea{
	//可导航性
	private $navigability=0;
	function __construct($navigability){
		$this->navigability=$navigability;
	}
}
 
//地球海洋
class EarthSea extends Sea{}
 
//火星海洋
class MarsSea extends Sea{}
 
//平原
class Plains{}
 
//地球平原
class EarthPlains extends Plains{}
 
//火星平原
class MarsPlains extends Plains{}
 
//森岭
class Forest{}
 
//地球森林
class EarthForest extends Forest{}
 
//火星森林
class MarsForest extends Forest{}
 
//地形工厂
class TerrainFactory{
	private $sea;
	private $forest;
	private $plains;
	
	function __construct(Sea $sea,Plains $plains,Forest $forest){
		$this->sea=$sea;
		$this->plains=$plains;
		$this->forest=$forest;
	}
	
	function getSea(){
		return clone $this->sea;
	}
	
	function getPlains(){
		return clone $this->plains;
	}
	
	function getForest(){
		return clone $this->forest;
	}
}
 
class Contained{}
 
class Container{
	public $contained;
	
	function __construct(){
		$this->contained=new Contained();
	}
	
	function __clone(){
		//确保被克隆的对象持有的是self::$contained的克隆而不是引用
		$this->contained=clone $this->contained;
	}
}
 
 
$factory=new TerrainFactory(new EarthSea(-1), new EarthPlains(), new EarthForest());
 
print_r($factory->getSea());
 
print "<hr>";
 
print_r($factory->getPlains());
 
print "<hr>";
 
print_r($factory->getForest());

// 原型模式要依赖客户通过 不念克隆过程使用具体原型.在这个设计过程中, 客户是完成克隆的参与者, 由于克隆是原型设计中的关键要素, 所以客户是一个基本参与者, 而不仅仅是一个请求类.

// 现代企业组织

// 在创建型设计模式方面,现代企业组织就非常适合原型实现.现在企业组织往往是复杂而庞大的层次结构, 像面向对象编程一样,要为很多共同的特征建模.现在通过一个例子描述软件工程公司.

// 软件工程公司是一个典型的现代组织.工程部(Engineering Department)负责创建产品,管理部(Management)处理资源的协调组织,市场部(Marketing)负责产品的销售,推广和整体营销.

// 接口中的封装
// <?php
// abstract class IAcmePrototype
// {
//   protected $name;
//   protected $id;
//   protected $employeePic;
//   protected $department;
//   //部门
//   abstract function setDept($orgCode);
//   abstract function getDept();
//   //名字
//   public function setName($emName)
//   {
//     $this->name = $emName;
//   }
//   public function getName()
//   {
//     return $this->name;
//   }
//   //ID
//   public function setId($emId)
//   {
//     $this->id = $emId;
//   }
//   public function getId()
//   {
//     return $this->id;
//   }
//   //雇员图像
//   public function setPic($ePic)
//   {
//     $this->employeePic = $ePic;
//   }
//   public function getPic()
//   {
//     return $this->employeePic;
//   }
//   abstract function __clone();
// }
// 在这个原型实现中,首先为程序的接口(一个抽象类)增加OOP,与所有原型接口一样,这个接口包含一个克隆操作.另外它还包含一些抽象和具体的获取方法和设置方法.
// 其中有一个抽象获取方法/设置方法对,但要由3个具体原型实现为这个抽象获取方法/设置方法对提供具体实现.其他获取方法和设置方法分分别应用于员工名,ID码和照片等属性.
// 注意所有这些属性都是保护属性(protected),所以尽管具体的获取方法和设置方法有公共可见性,但由于操作中使用的属性具有保护和可见性,这就提供了某种程度的封装:

// PHP世界中的原型

// 由于PHP是一个服务器端语言,也是与MySQL数据库交互的一个重要工具,所以原型设计模式尤其适用 .并不是为数据库的第一个元素分别创建对象,

// PHP可以使用原型模式创建具体类的一个实例,然后利用数据库中的数据克隆其余的实例(记录).

// 了解克隆过程之后,与直接实例化的过程相比,你可能会问:"这有什么区别?" 换句话说,为什么克隆比直接实例化对象需要的资源少?它们的区别并不能直接看到. 

// 一个对象通过克隆创建实例时, 它不会启动构造函数.克隆能得到原始类的所有属性, 甚至还包含父接口的属性,另外还继承了传递实例化对象的所有值.

// 构造函数生成的所有值以及存储在对象属性中的值都会成为克隆对象的一部分.所以没有返回构造函数.如果发现你的克隆对象确实需要访问构造函数生成的值但又无法访问,

// 这说明需要对类进行重构,使实例能拥有它们需要的一切信息, 而且可以把这些数据传递给克隆对象.

// 总的来说, 原型模式在很多不同类型的PHP项目中都很适用, 如果解决一个问题需要乃至创建型模式, 都可以使用原型模式.



// 浅拷贝与深拷贝
// 浅拷贝
// 被拷贝对象的所有变量都含有与原对象相同的值，而且对其他对象的引用仍然是指向原来的对象。 
// 即浅拷贝只负责当前对象实例，对引用的对象不做拷贝。

// 深拷贝
// 被拷贝对象的所有的变量都含有与原来对象相同的值，除了那些引用其他对象的变量。那些引用其他对象的变量将指向一个被拷贝的新对象，而不再是原有那些被引用对象。 
// 即深拷贝把要拷贝的对象所引用的对象也都拷贝了一次，而这种对被引用到的对象拷贝叫做间接拷贝。 
// 深拷贝要深入到多少层，是一个不确定的问题。 
// 在决定以深拷贝的方式拷贝一个对象的时候，必须决定对间接拷贝的对象是采取浅拷贝还是深拷贝还是继续采用深拷贝。 
// 因此，在采取深拷贝时，需要决定多深才算深。此外，在深拷贝的过程中，很可能会出现循环引用的问题。
 
// 浅拷贝实现
// <?php
// //原型类
// abstract class Prototype
// {
//     public function __construct($id){
//         $this->id=$id;
//     }
//     public function __get($name){
//         return $this->$name;
//     }
//     public function __set($name, $value)
//     {
//         $this->$name=$value;
//     }

//     public abstract  function clone();
// }

// //具体原型类
// class ConcretePrototype extends Prototype
// {
//     //返回自身
//     public function clone()
//     {
//         return clone $this;//浅拷贝
//     }
// }

// //测试浅拷贝
// class DeepCopyDemo
// {
//     public $array;
// }

// $demo=new DeepCopyDemo();
// $demo->array=array(1,2);
// $obj1=new ConcretePrototype($demo);
// $obj2=$obj1->clone();
// var_dump($obj1);
// var_dump($obj2);
// $demo->array=array(3,4);
// var_dump($obj1);
// var_dump($obj2);

// 深拷贝实现
// <?php
// //原型类
// abstract class Prototype
// {
//     public function __construct($id){
//         $this->id=$id;
//     }
//     public function __get($name){
//         return $this->$name;
//     }
//     public function __set($name, $value)
//     {
//         $this->$name=$value;
//     }

//     public abstract  function clone();
// }

// //具体原型类
// class ConcretePrototype extends Prototype
// {
//     //返回自身
//     public function clone()
//     {
//         $serialize_obj=serialize($this);
//         $clone_obj=unserialize($serialize_obj);
//         return $clone_obj;
//     }
// }
// //测试深拷贝
// class DeepCopyDemo
// {
//     public $array;
// }

// $demo=new DeepCopyDemo();
// $demo->array=array(1,2);
// $obj1=new ConcretePrototype($demo);
// $obj2=$obj1->clone();
// var_dump($obj1);
// var_dump($obj2);
// $demo->array=array(3,4);
// var_dump($obj1);
// var_dump($obj2);