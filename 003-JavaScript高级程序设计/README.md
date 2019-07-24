本书从最早期Netscape浏览器中的JavaScript开始讲起，直到当前它对XML和Web服务的具体支持，内容主要涉及JavaScript的语言特点、JavaScript与浏览器的交互、更高级的JavaScript技巧，以及与在Web应用程序中部署JavaScript解决方案有关的问题，如错误处理、调试、安全性、优化/混淆化、XML和Web服务，最后介绍应用所有这些知识来创建动态用户界面。

作者简介

Nicholas C.Zakas世界知名的JavaScript专家和Web开发人员。

Nicholas拥有丰富的Web开发和界面设计经验，曾经参与许多世界大公司的Web解决方案开发，并与他人合作撰写了畅销书《Ajax高级程序设计》。  

这一系列围绕
这一系列文章主要围绕：

如何阅读《JavaScript...》

全书的脉络是什么？

预备知识：像我这种小白，有时真的看的是一脸糊涂。

还没想好，，，

全书的划分

在看书之前，先大体看一下目录，将全书划分一下，对每一个有大体的了解。可分为：
```
（1-2章） ：可以通俗的认为讲故事和环境搭建。
（3-7章） ：javaScript基本语法和思想。
（8-9章） ：BOM（浏览器对象模型）
（10-14章）：使用DOM与html进行交互
（15-16章）：复杂的效果实现。
（17章） ：错误处理
（18-19章）：javaScript与XML基础
（20-21章）：服务器相关（JSON，Ajax，comet等等）
（22章）：高级技巧
（23章）：离线技术
（24章）：实践环节
（25章）：新兴API
```
本篇文章主要讨论前两项内容，即1-7章。
## （1）JavaScript简史
把握重点
因为语法是个死的东西，所以在我看来,前面5章的内容是基础中的基础，而后面的6-7章的内容则是传达的一种思想-面向对象。所以在学习的时候，先把握重点。

好了现在进入正题，现在可以打开书的第一章了，然后看完下面的预备知识，再看书。

预备知识:
Netscape Navigator是一个浏览器，浏览器！！！以下简称NN浏览器。

总结梳理
### 1. JavaScript的“捡屎”
Netscape我们叫他网基公司，它有一个浏览器NN浏览器
NN快要发布到2代的时候，网基觉得自己牛逼了，所以想要解决表单验证的烦恼。
网基就加班加点开始开发这个脚本语言
在命名的时候，为了火，我们叫他蹭热度，改名成了JavaScript
这个热度蹭的可太好了，很成功，很火，微软老大哥一看，这不行啊，老子的IE浏览器不能输！IE就抄了一手，为了版权的问题，那就改名字吧，就叫Jscript
两家发展越来越壮大，web越来越重要，两家的Javascript版本也会越来越分歧，so某某协会开始了标准化，这个标准就叫做ECMAScript。
ECMAScript
由你所见，他作为标准，并不规定运行环境，只是规定了语法，类型，语句，关键字，保留字，操作符，对象。
目前已经到第八个版本，ES8（简写），但是本书写到了ECS5，，，，长路漫漫。。。。
关于版本的更新问题，有人做了一张图，拿来了，不知道有没有问题。
图片来源见水印

## （2-5）JavaScript的语法
关注的重点
这里面有一个重要的知识就是MIME类型，在后面会遇到，如果忘了的话，会看的很糊涂。
MIME类型：编写代码使用的脚本语言的内容类型 可以是text/html 也可以是text/javascript

总结梳理
相当于别的语言的环境搭建
如何在浏览器中使用JavaScript呢？需要用到HTML。所以就引出了几个问题

怎么嵌套到HTML中？在HTML的位置有何不同？不同的位置对与执行情况有何不同？不同的文档怎么引入？属性有哪些？哪些是可选属性，哪些是必须属性？
如何执行？执行顺序？
<noscript>元素的作用？
按照这个内容自己想一下，在书中都可以找到答案。

JavaScript的语法不同之处
和c java语言有很多相似之处，所以在这里就重点说一下不同之处。

### 1. 松散类型
var message; var message = 16; message = "hello";也就是一个变量能够存所有的类型。甚至我们都可以不用加var 像这样定义就会直接创建全局变量message = 16(因为有了window对象，所以实际是window.message = 16')。

### 2. 没有块级作用域
不像其他语言{}内容里面的都是块级作用域，而在JavaScript中是没有这一说的。它的作用域法则是不一样的。

在JavaScript中，把这个东西叫做，执行环境。注意，执行环境只分为两种全局执行环境（除函数之外的环境）和局部执行环境（只有函数内部的区域是局部的。）每个执行环境都有一个与之相关联的变量对象（所有的变量与函数保存在里面）
对于全局执行环境来说，对象就是window对象，而对于局部（函数）环境来说，称为活动对象（最开始至包含arguments对象）

环境结束就会销毁，其里面的变量，函数。全局环境的关闭是页面关闭或者浏览器关闭，而局部环境的关闭是指函数结束。

因为这个道理就可以在函数内部建立相同的变量。（两个对象不同）

其查询标识符是从下道上的一个过程，例如下面的代码：
```
var color = "blue";

function getColor() {
    var color = "red";
    return color;
}
```
alert(getColor()); //"red"
搜索的过程就是先搜索getColor()的变量对象，是否包含color，是就结束，否就找下一个变量对象（此例子中是全局对象即window对象），都找不到的话就返回undefined

### 3.[]表示法
和其他语言不同，在javaScript中[]不止用在数组中，它还可以用在对象上面。如我们现在建立一个名为dog的对象，如果我们想要访问name属性，那么可以这么写：dog["name"]，【注意】属性是以字符串的形式的。

JavaScript语法脉络
看完了不同之处，最难理解的东西就已经掌握了，其他的就是一些细小的东西了，只需要按照一定的逻辑背一下熟悉熟悉，多练多实践，我就觉得够了，这也是笔者的看法。

学习的脉络就是根据不同的类型开始逐一熟悉。

## 1.数据类型
注意数据类型指的是数据的类型。
分为五种基本类型，和一种复杂类型。
五种基本类型：Undefined,Null,Boolean,Number,String
一种复杂类型：Object.

提到这个就很自然的想到，既然是松散类型的，该怎么检测给定变量的数据类型呢？
答案是typeof操作符，注意是操作符。

他返回的是："undefined" "string""number" "boolean" "object" "function"

用法：typeof 变量或typeof(变量）

## 2.Undefined类型
Undefined类型我把它理解为未被定义过的类型，是一个undefined值，
这有两种情况：

定义了一个变量，但没有初始化。
未定义一个变量。
体会一下两个的区别：
```
alert(message);//会显示错误信息
alert(typeof message);//"undefined"值
```

## 3.Null
Null类型只有一个null值的类型。null值是一个空对象指针，所以typeof null返回的是"object"

而undefined就是由null值派生出来的。

所以undefined == null返回的是true

## 4.Number类型
转换问题：

这是一个很清晰的脉络，对于不同类型的值怎么转换是一个很大的问题。
所以方法有Number()、parseInt()、parseFloat().
不同方法的规则是什么？

### 整数类型：

十进制的表示，八进制的表示，以及16进制的表示。

### 浮点数类型：
自动转换整数的特点，e表示法。

### 数值范围：
最大和最小的范围是？超出范围的数字如何表示？

### NaN：
NaN是一个特殊的值。有两个特点

涉及任何NaN的操作都返回NaN
与任何值都不想等，包括本身NaN

## 5.String类型：
Unicode字符组成的字符串。

转换问题

同样是转换问题，这一个脉络还是很清晰。
String(),toString()方法。它们分别转换的规则是什么？对于数值型的转换有没有什么不一样的地方？对于null和undifined呢？

## 6.引用类型
为什么会多出一个引用类型呢？所谓引用类型实际是一个数据结构，是描述一类对象的属性和方法。和“类”相似。它与对象是什么关系呢？对象是某一个引用类型的实例。

在上面说的一种复杂数据类型Object就是指的是引用类型，是一种大的概念。

如何学习这里面的内容呢？由于对象就是一系列的属性和方法，所以重点是常用的属性和方法，而这一点也没有什么难度，无非就是熟练的过程。还是多练。

## 引用类型的创建

new标识符。如 var message = new Object(); var item = new Array();

以下列出几种重要的引用类型，对于方法和属性的细节，暂时抛弃。

## 1） Object类型
对于Object的创建除了new 还有 字面量，即：
```
var message = {
    name : helo,
    color : red,
    
    ...
    
}
```
【注意】在使用字面量的时候，是不调用构造方法的。

## 2）Array类型
同样的创建一个Array的对象也有不同的方法：
例如：
```
var colors = new Array(2);//数组的长度为2.
var colors = ["red","blue","green"];//用[]来创建一个特定的数组
```
当然JavaScript中的数组更加神童广大，最大的区别就是：数组长度可变。

相关的方法，请具体查阅书籍。
 
## 3）Date类型
## 4）RegExp类型
## 5）Function类型
 
这里要提一下了，在Javascript中，每个函数都是Function类型的实例，也可以说是对象。
所以可以这么写代码：var sum = new Function("num1","num2","return num1 + num2");
但是不建议。

另外两种定义一个函数的方法是：function sum (num1,num2) {...}//函数声明 var sum = function(num1,num2){...}//函数初始化

这两种定义的方式是有区别的，
【函数声明】：在代码执行之前，解析器读取并将函数声明添加到执行环境中去。所以以下代码是没有问题的。
```
alert(sum(10,10));
function sum(num1,num2){
    return num1 + num2;
}
```
【函数自定义】：则是在执行到函数之前，是不会保存的。所以以下代码会出现“unexpected identifier”错误
```
alert(sum(10,10));
var sum = function(num1,mum2) {
    return num1 + num2;
};
```
另一个方面既然函数是对象的话，函数名是指针变量，那么就可以把这个函数变量，当作参数，传递给另一个函数。

同时它还应该有属性和方法。具体有哪些属性自己回忆或查阅。

在这里重点提一下 prototype属性，对于引用类型而言，prototype是保存他们所有实例方法的真正所在。（后面会更加详细的讲解。）

## 6）基本包装类型
为了便于操作基本类型，又创建出了特殊的引用类型，Boolean、Number、String。

实际上读取一个基本类型，他就会自动的创建各自的实例,执行相关操作，然后就会销毁
如：
```
var s1 = "some text";
var s2 = s1.substring(2);
```
下面的代码就体现了销毁过程
```
var s1 = "some text";//在内部的过程
s1.color = "red";
alert(s1.color);
```
在第一行代码中，创建了一个实例，创建了字符串，随之销毁，第二行又重新创建了一个实例，附上red后，销毁，在第三行中在执行中，又创建了一个实例，此时实例的属性是undefined。

同时Object构造函数也具有这个功能。
如：
```
var obj = new Object("some text");//自动返回基本包装类型的实例
alert（obj instanceof String）;//true
```
三种各自的包装类型详细方法自己回忆。

## 7）单体内置对象
这些书有一大特点，就是里面的名词真的让你心惊胆战，明明很简单的事情，非要弄个你不熟悉的名字吓唬你。

单体内置对象，就是不依赖宿主环境的对象，在程序执行之前就已经存在。有两个 Global和Math

## Global对象
书中写的很有意思，叫做“终极兜底儿对象”，所有不属于其他对象的属性和方法，最终都是他的属性和方法

你一定想知道之前不是有window对象吗？他们两个是一个什么关系，现在先保留这个问题。

Global是一个虚拟的东西，他不能new出来，但是却是真实存在的。所有在全局作用域中定义的属性和函数，最终都是它的属性和方法。其里面还有一些内置的函数，诸如我们之前了解过的isNaN(),isFinite(),parseInt(),parseFloat()等等，都是Global的方法。

现在我们就来说一下window是一个什么东西，之前说过在全局作用域中定义的属性和方法，其实都可以用window.XX来访问得到，因为不能直接访问Global对象，所以window对象实现了Global对象的一部分，全局作用域中属性和函数，就都成为了window对象的属性和方法。

接下来Global对象的属性和方法请自行回忆脑补。

## Math对象
对于Math对象没有什么难理解的，同样沿着他的属性和方法回忆就好。。

JavaScript的面向对象
首先这一思想是最重要的，也是以后的基础，所以脉络清楚对于有好处。

到目前为止，我们怎么两种方法创建对象：

### 1.利用函数创建对象，并且返回。
```
function createPerson(name,age,job) {
    var o = new Object();
    o.name = name;
    o.age = age;
    o.job = job;
    o.sayName = function() {
        alert(this.name);
        
    };
    return o;
}
var person1 = createPerson("Nicholas",29,"Software Engineer");
var person2 = createPerson("Greg",27,"Doctor");
```

### 2.使用new操作符
```
function Person(name,age,job) {
    this.name = name;
    this.age = age;
    this.job = job;
    this.sayName =  function() {
        alert(this.name);
    };
    
}

var person1 = new Person("Nicholas",29,"Software Engineer");
var person2 = new Person("Greg",27,"Doctor");
```
用构造方法来创建的实例中，这两个对象都有一个constructor(构造函数）属性，该属性指向Person。

但是目前的这个构造方法创建对象是有问题的，回想一下每个函数其实都是Function的一个实例，在以上创建person1和person2的时候，虽然两个函数是一样的，但是需要在里面创建两个不同的Function实例，所以可以改进一下：
```
function Person(name,age,job) {
    this.name = name;
    this.age = age;
    this.job = job;
    this.sayName =  sayName;
    
}
function sayName() {
        alert(this.name);
}

var person1 = new Person("Nicholas",29,"Software Engineer");
var person2 = new Person("Greg",27,"Doctor");
```
这样一来虽然可以解决问题，但是如果有很多函数的话，就需要在外面定义好多函数，就体现不了封装的思想了。为了解决这一问题，就出现了原型。（prototype）

关于原型

每个对象都有一个私有属性（称之为 [[Prototype]]），它持有一个连接到另一个称为其 prototype 对象（原型对象）的链接。该 prototype 对象又具有一个自己的原型，层层向上直到一个对象的原型为 null。根据定义，null 没有原型，并作为这个原型链中的最后一个环节
再看一下书中的那个示意图，会很明白。

关于几个方法：isPrototypeOf()是否为某个对象的原型Person.prototype.isPrototypeOf(person1)//true 
Object.getPrototypeOf() 得到某个对象的原型。alert(Object.getPrototypeOf(person1).name;//"Nicholas"
hasOwnProperty()方法可以检测一个属性是否存在实例中。
alert(person1.hasOwnProperty("name"));//true

原型创建
```
function Person() {}
Person.prototype = {
    constructor:Person;
    name:"nigulasi",
    age:29,
    job:"Software Engineer",
    sayName：function() {
        alert(this.name);
    }
};
```
组合创建
以上两种方式都有各自的缺点，取他们的长处组合，是一个很好的方法。
```
function Person(name,age,job) {
    this.name=name;
    this.age=age;
    this.job=job;
    this.friends=["Shelby","Court"];
    
}

Person.prototype = {
    constructor:Person;
    sayName:function(){
        alert(this.name);
    }
};
```
实例属性都是在构造函数中定义的，而所有实例共享的属性constructor和方法sayName()则是在原型中定义的。

3.关于继承

原型链继承
```
//组合方法创建父级对象
function Animal(name,age) {
    this.name=name;
    this.age = age;
}
Dog.prototype.getName() {
    alert(this.name);
}
//组合方法创建对象，利用原型继承
function Dog(name,age) {
    this.name = name;
    this.age = age;
}

//实现继承
Dog.prototype = new Animal();
```

构造函数实现继承
```
function Super() {
    this.colors = ["red","blue","green"];
}
function Sub() {
    //继承自Super
    Super.call(this);//使用apply()和call()方法可以在新创建的对象上执行构造函数。
    
}
```

组合继承
同样集两种之所长。
```
function Super(name) {
    this.name = name;
    this.colors = ["red","blue","green"];
    
}

Super.prototype.sayName = function(){
    alert(this.name);
};

function Sub(name,age) {
    //继承属性
    Super.call(this.name);
    this.age = age;
}

//继承方法
Sub.prototype = new Super();
sub.prototype.contructor =sub
Sub.prototype.sayAge = function() {
    alert（this.age）;
}；
```