php的引用（就是在变量或者函数、对象等前面加上&符号）

在PHP 中引用的意思是：不同的名字访问同一个变量内容。
与Ｃ语言中的指针是有差别的．Ｃ语言中的指针里面存储的是变量的内容，在内存中存放的地址。

## 1.变量的引用

PHP 的引用允许你用两个变量来指向同一个内容
``` 
<?php
    $a="ABC";
    $b =&$a;
    echo $a;//这里输出:ABC
    echo $b;//这里输出:ABC
    $b="EFG";
    echo $a;//这里$a的值变为EFG 所以输出EFG
    echo $b;//这里输出EFG
?>
```
 
## 2.函数的引用传递（传址调用）

传址调用我就不多说了 下面直接给出代码
```
<?php

    function test(&$a){
        $a=$a+100;
    }
    $b=1;
    echo $b;//输出１

    test($b);   //这里$b传递给函数的其实是$b的变量内容所处的内存地址，通过在函数里改变$a的值　就可以改变$b的值了

    echo "<br>";
    echo $b;//输出101
?>
```
 
要注意的是，在这里test(１);的话就会出错，原因自己去想。

注意：

    上面的“ test($b); ” 中的$b前面不要加 & 符号，但是在函数“call_user_func_array”中，若要引用传参，就得需要 & 符号，如下代码所示：

```
<?php
function a(&$b){
    $b++;
}
$c=0;

call_user_func_array('a',array(&$c));

echo $c;

//输出 1

?>
```
 

## 3.函数的引用返回 

先看代码

```
<?php
function &test(){
    static $b=0;//申明一个静态变量
    $b=$b+1;
    echo $b;
    return $b;
}

$a=test();//这条语句会输出　$b的值　为１
$a=5;
$a=test();//这条语句会输出　$b的值　为2

$a=&test();//这条语句会输出　$b的值　为3
$a=5;
$a=test();//这条语句会输出　$b的值　为6
?>
```

下面解释下：　

通过这种方式$a=test();得到的其实不是函数的引用返回，这跟普通的函数调用没有区别　至于原因：　这是ＰＨＰ的规定ＰＨＰ规定通过$a=&test(); 方式得到的才是函数的引用返回至于什么是引用返回呢（ＰＨＰ手册上说：引用返回用在当想用函数找到引用应该被绑定在哪一个变量上面时。) 这句狗屁话　害我半天没看懂

用上面的例子来解释就是

$a=test()方式调用函数，只是将函数的值赋给$a而已，　而$a做任何改变　都不会影响到函数中的$b而通过$a=&test()方式调用函数呢, 他的作用是　将return $b中的　$b变量的内存地址与$a变量的内存地址　指向了同一个地方即产生了相当于这样的效果($a=&$b;) 所以改变$a的值　也同时改变了$b的值　所以在执行了
```
$a=&test();
$a=5;
```
以后，$b的值变为了5

这里是为了让大家理解函数的引用返回才使用静态变量的，其实函数的引用返回多用在对象中


另附一个php官方例子： 
``` 
This is the way how we use pointer to access variable inside the class.

<?php
class talker{

    private $data = 'Hi';

    public function & get(){
        return $this->data;
    }
   
    public function out(){
        echo $this->data;
    }   

}

$aa = new talker();
$d = &$aa->get();

$aa->out();
$d = 'How';
$aa->out();
$d = 'Are';
$aa->out();
$d = 'You';
$aa->out();
?>
```
```
the output is "HiHowAreYou"
```

## 4.对象的引用
```
<?php
    class a{
        var $abc="ABC";
    }
    $b=new a;
    $c=$b;
    echo $b->abc;//这里输出ABC
    echo $c->abc;//这里输出ABC
    $b->abc="DEF";
    echo $c->abc;//这里输出DEF
?>
```
以上代码是在PHP5中的运行效果

 

在PHP5中 对象的赋值是个引用的过程。上列中$b=new a; $c=$b; 其实等效于$b=new a; $c=&$b;

PHP5中默认就是通过引用来调用对象， 但有时你可能想建立一个对象的副本，并希望原来的对象的改变不影响到副本 . 为了这样的目的，PHP5定义了一个特殊的方法，称为__clone。

自 PHP 5 起，new 自动返回引用，因此在此使用 =& 已经过时了并且会产生 E_STRICT 级别的消息。
 

在php4中，对象的赋值是个拷贝过程，

如：$b=new a，其中new a产生的是一个匿名的a对象实例，而此时的$b是对这个匿名对象的拷贝。同理$c=$b，也是对$b内容的一个拷贝。所以在php4中，为了节省内存空间，$b=new a 一般会改成引用的模式，即 $b=& new a。

 

下面再来个 官方 提供的例子：

 在php5中，你不需要额外添加什么东西就可到达“对象引用”的功能：

```
<?php
class foo{
        protected $name;
        function __construct($str){
                $this->name = $str;
        }
        function __toString(){
                return  'my name is "'. $this->name .'" and I live in "' . __CLASS__ . '".' . "\n";
        }
        function setName($str){
                $this->name = $str;
        }
}

class MasterOne{
        protected $foo;
        function __construct($f){
                $this->foo = $f;
        }
        function __toString(){
                return 'Master: ' . __CLASS__ . ' | foo: ' . $this->foo . "\n";
        }
        function setFooName($str){
                $this->foo->setName( $str );
        }
}

class MasterTwo{
        protected $foo;
        function __construct($f){
                $this->foo = $f;
        }
        function __toString(){
                return 'Master: ' . __CLASS__ . ' | foo: ' . $this->foo . "\n";
        }
        function setFooName($str){
                $this->foo->setName( $str );
        }
}

$bar = new foo('bar');

print("\n");
print("Only Created \$bar and printing \$bar\n");
print( $bar );

print("\n");
print("Now \$baz is referenced to \$bar and printing \$bar and \$baz\n");
$baz =& $bar;
print( $bar );

print("\n");
print("Now Creating MasterOne and Two and passing \$bar to both constructors\n");
$m1 = new MasterOne( $bar );
$m2 = new MasterTwo( $bar );
print( $m1 );
print( $m2 );

print("\n");
print("Now changing value of \$bar and printing \$bar and \$baz\n");
$bar->setName('baz');
print( $bar );
print( $baz );

print("\n");
print("Now printing again MasterOne and Two\n");
print( $m1 );
print( $m2 );

print("\n");
print("Now changing MasterTwo's foo name and printing again MasterOne and Two\n");
$m2->setFooName( 'MasterTwo\'s Foo' );
print( $m1 );
print( $m2 );

print("Also printing \$bar and \$baz\n");
print( $bar );
print( $baz );
?>
```

输出：
```
Only Created $bar and printing $bar
my name is "bar" and I live in "foo".

Now $baz is referenced to $bar and printing $bar and $baz
my name is "bar" and I live in "foo".

Now Creating MasterOne and Two and passing $bar to both constructors
Master: MasterOne | foo: my name is "bar" and I live in "foo".

Master: MasterTwo | foo: my name is "bar" and I live in "foo".


Now changing value of $bar and printing $bar and $baz
my name is "baz" and I live in "foo".
my name is "baz" and I live in "foo".

Now printing again MasterOne and Two
Master: MasterOne | foo: my name is "baz" and I live in "foo".

Master: MasterTwo | foo: my name is "baz" and I live in "foo".


Now changing MasterTwo's foo name and printing again MasterOne and Two
Master: MasterOne | foo: my name is "MasterTwo's Foo" and I live in "foo".

Master: MasterTwo | foo: my name is "MasterTwo's Foo" and I live in "foo".

Also printing $bar and $baz
my name is "MasterTwo's Foo" and I live in "foo".
my name is "MasterTwo's Foo" and I live in "foo".
```
上个例子解析：
```
$bar = new foo('bar');
$m1 = new MasterOne( $bar );
$m2 = new MasterTwo( $bar );
```
实例对象$m1与$m2中的$bar是对实例$bar的引用，而非拷贝，这是php5中，对象引用的特点，也就是说

1.$m1或$m2内部，任何对$bar的操作都会影响外部对象实例$bar的相关值。

2.外部对象实例$bar的改变也会影响$m1和$m2内部的$bar的引用相关值。
 
在php4中，要实现如上述的 用一个对象实例去当着另外一个对象的属性时，其等价代码（即引用调用）类似如下：
```
class foo{
   var $bar;
   function setBar(&$newBar){
      $this->bar =& newBar;
   }
}
```

## 5.引用的作用
如果程序比较大,引用同一个对象的变量比较多,并且希望用完该对象后手工清除它,个人建议用 "&" 方式,然后用$var=null的方式清除. 其它时候还是用php5的默认方式吧. 另外, php5中对于大数组的传递,建议用 "&" 方式, 毕竟节省内存空间使用。


## 6.取消引用
当你 unset 一个引用，只是断开了变量名和变量内容之间的绑定。这并不意味着变量内容被销毁了。例如： 
```
<?php
    $a = 1;
    $b =& $a;
    unset ($a);
?>  
```
不会 unset $b，只是 $a。 

## 7.global 引用
当用 global $var 声明一个变量时实际上建立了一个到全局变量的引用。也就是说和这样做是相同的： 
```
<?php
    $var =& $GLOBALS["var"];
?> 
``` 
这意味着，例如，unset $var 不会 unset 全局变量。 


 如果在一个函数内部给一个声明为 global 的变量赋于一个引用，该引用只在函数内部可见。可以通过使用 $GLOBALS 数组避免这一点。

Example  在函数内引用全局变量

```
<?php
$var1 = "Example variable";
$var2 = "";

function global_references($use_globals){
    global $var1, $var2;
    if (!$use_globals) {
        $var2 =& $var1; // visible only inside the function
    } else {
        $GLOBALS["var2"] =& $var1; // visible also in global context
    }
}

global_references(false);
echo "var2 is set to '$var2'\n"; // var2 is set to ''
global_references(true);
echo "var2 is set to '$var2'\n"; // var2 is set to 'Example variable'
?>
```
把 global $var; 当成是 $var =& $GLOBALS['var']; 的简写。从而将其它引用赋给 $var 只改变了本地变量的引用。
 

## 8.$this
在一个对象的方法中，$this 永远是调用它的对象的引用。

//下面再来个小插曲
php中对于地址的指向（类似指针）功能不是由用户自己来实现的，是由Zend核心实现的，php中引用采用的是“写时拷贝”的原理，就是除非发生写操作，指向同一个地址的变量或者对象是不会被拷贝的。

通俗的讲

1:如果有下面的代码
```
<?php
    $a="ABC";
    $b=&$a;
?>
```
其实此时　$a与$b都是指向同一内存地址　而并不是$a与$b占用不同的内存

２:如果在上面的代码基础上再加上如下代码
```
<?php
  $a="EFG";
?>
```
由于$a与$b所指向的内存的数据要重新写一次了，此时Zend核心会自动判断　自动为$b生产一个$a的数据拷贝，重新申请一块内存进行存储


php的引用（就是在变量或者函数、对象等前面加上&符号）是个高级话题，新手多注意，正确的理解php的引用很重要，对性能有较大影响，而且理解错误可能导致程序错误！

很 多人误解php中的引用跟C当中的指针一样，事实上并非如此，而且很大差别。C语言中的指针除了在数组传递过程中不用显式申明外，其他都需要使用*进行定 义，而php中对于地址的指向（类似指针）功能不是由用户自己来实现的，是由Zend核心实现的，php中引用采用的是“写时拷贝”的原理，就是除非发生 写操作，指向同一个地址的变量或者对象是不会被拷贝的，比如下面的代码：
```
$a = array('a','c'...'n');
$b = $a;
```
如 果程序仅执行到这里，$a和$b是相同的，但是并没有像C那样，$a和$b占用不同的内存空间，而是指向了同一块内存，这就是php和c的差别，并不需要 写成$b=&$a才表示$b指向$a的内存，zend就已经帮你实现了引用，并且zend会非常智能的帮你去判断什么时候该这样处理，什么时候不 该这样处理。

如果在后面继续写如下代码，增加一个函数，通过引用的方式传递参数，并打印输出数组大小。
```
function printArray(&$arr){ //引用传递
   print(count($arr));
}
printArray($a);
```
上面的代码中，我们通过引用把$a数组传入printArray()函数，zend引擎会认为printArray()可能会导致对$a的改变，此时就会自动为$b生产一个$a的数据拷贝，重新申请一块内存进行存储。这就是前面提到的“写时拷贝”概念。

如果我们把上面的代码改成下面这样：
```
function printArray($arr){   //值传递
   print(count($arr));
}
printArray($a);
```
上面的代码直接传递$a值到printArray()中，此时并不存在引用传递，所以没有出现写时拷贝。

大家可以测试一下上面两行代码的执行效率，比如外面加入一个循环1000次，看看运行的耗时，结果会让你知道不正确使用引用会导致性能下降30%以上。

自我理解：按传值的话是与函数内的参数无关，相当于局部变量的作用，而按传址（引用）的话却与函数内的参数有关，相当于全局变量的作用．而从性能方面来说，看上面分析就够．