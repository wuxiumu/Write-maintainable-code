## PHP闭包 function() use()

php的闭包（Closure）也就是匿名函数。是PHP5.3引入的。
闭包的语法很简单，需要注意的关键字就只有use，use意思是连接闭包和外界变量。

$a =function()use($b) {
 
}


## 闭包的几个作用：
### 1 减少foreach的循环的代码
比如手册http://php.net/manual/en/functions.anonymous.php 中的例子Cart
```
<?php
// 一个基本的购物车，包括一些已经添加的商品和每种商品的数量。
// 其中有一个方法用来计算购物车中所有商品的总价格。该方法使用了一个closure作为回调函数。
class Cart
{
    const PRICE_BUTTER  = 1.00;
    const PRICE_MILK    = 3.00;
    const PRICE_EGGS    = 6.95;
 
    protected   $products =array();
     
    public function add($product,$quantity)
    {
        $this->products[$product] = $quantity;
    }
     
    public function getQuantity($product)
    {
        return isset($this->products[$product]) ? $this->products[$product] :
               FALSE;
    }
     
    public function getTotal($tax)
    {
        $total = 0.00;
         
        $callback =
            function ($quantity,$product)use ($tax, &$total)
            {
                $pricePerItem = constant(__CLASS__ ."::PRICE_" .
                    strtoupper($product));
                $total += ($pricePerItem *$quantity) * ($tax + 1.0);
            };
         
        array_walk($this->products,$callback);
        return round($total, 2);;
    }
}
 
$my_cart =new Cart;
 
// 往购物车里添加条目
$my_cart->add('butter', 1);
$my_cart->add('milk', 3);
$my_cart->add('eggs', 6);
 
// 打出出总价格，其中有 5% 的销售税.
print $my_cart->getTotal(0.05) . "\n";
// The result is 54.29
?>
```


这里如果我们改造getTotal函数必然要使用到foreach 

### 2 减少函数的参数
```
function html ($code ,$id="",$class=""){
 
if ($id !=="")$id =" id = \"$id\"" ;
 
$class = ($class !=="")?" class =\"$class\"":">";
 
$open ="<$code$id$class";
 
$close ="</$code>";
 
return function ($inner ="")use ($open,$close){
 
return "$open$inner$close";};
 
}
```

如果是使用平时的方法，我们会把inner放到html函数参数中，这样不管是代码阅读还是使用都不如使用闭包

### 3 解除递归函数
```
<?php
    $fib =function($n)use(&$fib) {
        if($n == 0 || $n == 1) return 1;
        return $fib($n - 1) + $fib($n - 2);
    };
 
   echo $fib(2) . "\n";// 2
   $lie =$fib;
   $fib =function(){die('error');};//rewrite $fib variable 
   echo $lie(5);// error   because $fib is referenced by closure
```

注意上题中的use使用了&，这里不使用&会出现错误n-1)是找不到function的（前面没有定义fib的类型）

所以想使用闭包解除循环函数的时候就需要使用
```
<?php
$recursive =function ()use (&$recursive){
// The function is now available as $recursive
}
```

这样的形式

### 4 关于延迟绑定
如果你需要延迟绑定use里面的变量，你就需要使用引用，否则在定义的时候就会做一份拷贝放到use中
```
<?php
$result = 0;
 
$one =function()
{ var_dump($result); };
 
$two =function()use ($result)
{ var_dump($result); };
 
$three =function()use (&$result)
{ var_dump($result); };
 
$result++;
 
$one();   // outputs NULL: $result is not in scope
$two();   // outputs int(0): $result was copied
$three();   // outputs int(1)
```

使用引用和不使用引用就代表了是调用时赋值，还是申明时候赋值 