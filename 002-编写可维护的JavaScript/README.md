《编写可维护的JavaScript》向开发人员阐述了如何在团队开发中编写具备高可维护性的JavaScript代码，书中详细说明了作为团队一分子，应该怎么写JavaScript。

《编写可维护的JavaScript》内容涵盖了编码风格、编程技巧、自动化、测试等几方面，既包括具体风格和原则的介绍，也包括示例和技巧说明，最后还介绍了如何通过自动化的工具和方法来实现一致的编程风格。

《编写可维护的JavaScript》适合前端开发工程师、JavaScript程序员和学习JavaScript编程的读者阅读，也适合开发团队负责人、项目负责人阅读。

作者介绍 

Nicholas C. Zakas是一名前端开发顾问、作者和演讲家。

在Yahoo！供职超过5年时间，在这期间他曾是Yahoo！首页首席前端工程师和YUI库代码贡献者。

他著有《JavaScript高级程序设计》、《Ajax高级程序设计》和《高性能JavaScript》等书籍。

Zakas倡导了很多最佳实践，包括渐进增强、可访问性、性能、扩展性和可维护性等。

## 第一章 基本的格式化
缩进层级：推荐 tab:4;

换行：在运算符后面换行，第二行追加两个缩进；

```
// Good: Break after operator, following line indented two levels
callAFunction(document, element, window, "some string value", true, 123,
        navigator);

// Bad: Following line indented only one level
callAFunction(document, element, window, "some string value", true, 123,
    navigator);

// Bad: Break before operator
callAFunction(document, element, window, "some string value", true, 123
        , navigator);
```
添加空行：在方法之间； 在方法的局部变量和第一条语句之间； 在多行或单行注释之前； 在方法内的逻辑片段插入空行提高可读性（比如for， if）；

```
// good
if (wl && wl.length) {

    for (i = 0, l = wl.length; i < l; ++i) {
        p = wl[i];
        type = Y.Lang.type(r[p]);

        if (s.hasOwnProperty(p)) {

            if (merge && type == 'object') {
                Y.mix(r[p], s[p]);
            } else if (ov || !(p in r)) {
                r[p] = s[p];
            }
        }
    }
}
```
常量：采用大写字符加下划线的方式（var MAX_COUNT）；

```
var MAX_COUNT = 10;
var URL = "http://www.nczonline.net/";

if (count < MAX_COUNT) {
    doSomething();
}
```
不推荐显示的构建数组和对象（采用new的方式）；

字符串：推荐使用双引号； 
```
// Good
var name = "Nicholas";

// Bad: Single quotes
var name = 'Nicholas';

// Bad: Wrapping to second line
var longString = "Here's the story, of a man \
named Brady.";
```
不要使用“\”来连接字符串，推荐使用“+”；

## 第二章 注释
注释：注释前面空一行，与下一行对其； 程序代码比较明了的时候，不推荐添加注释； 可能被认为错误的代码可加注释提醒不要随意修改；  
```
/*
 *注意前面的空格（不好）
 * 注意前面的空格（好）
 *／
```

## 第三章 语句和表达式
块语句间的空格，推荐使用下面这种
```
if (condition) {
    doSomething();
}
```
不要使用 for in 来循环数组，因为 index 是字符串形式，而不是数字形式，容易出现问题。可以用来循环对象；

## 第四章 变量、函数和运算符
严格模式：只在需要的地方添加，尽量不要全局使用，除非你已经明确都要严格模式。
```
// 推荐使用方式
function fn() {
    "use strict";
    //代码
}

//或者
(function() {
    "use strict";
    function fn1() {

    }
    function fn2() {
        
    }
})();
```
相等：推荐使用“===” 和 “！==”这样可以避免转换，出现潜在的风险;

尽量不适用 eval , Function, 以及不要给 setTimeout，setInterval 传入字符串;

## 第五章 UI的松耦合
避免使用css 表达式 expression;

用 js 修改样式的时候，采用添加或者移除类名的方式，而不是直接使用.style.color .style.cssText;

```
// Bad
element.style.color = "red";
element.style.left = "10px";
element.style.top = "100px";
element.style.visibility = "visible";

element.style.cssText = "color: red; left: 10px; top: 100px; visibility: hidden";

//样式
.reveal {
    color: red;
    left: 10px;
    top: 100px;
    visibility: visible;
}

// Good - Native
element.className += " reveal";

// Good - HTML5
element.classList.add("reveal");

// Good - YUI
Y.one(element).addClass("reveal");

// Good - jQuery
$(element).addClass("reveal");

// Good - Dojo
dojo.addClass(element, "reveal");
```

在HTML中不要使用javascript；比如嵌入在HTML中的onClick
```
<!-- Bad -->

<button onclick="doSomething()" id="action-btn">Click Me</button>

将HTML从JavaScript中 抽离。

// Bad
var div = document.getElemenetById("my-div");
div.innerHTML = "<h3>Erroe</h3>";
```

解决办法有三种：1、从服务器加载；
```
function loadDialog(name, oncomplete) {
    var xhr = new XMLHttpRequest();
    xhr.open("get", "/js/dialog/" + name, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var div = document.getElementById("dlg-holder");
            div.innerHTML = xhr.responseText;
            oncomplete();
        } else {
            // handle error
        }
    };
    xhr.send(null);
}
```

2、使用简单客户端模板；
```
// 模板
<li><a href="%s">%s</a></li>

function sprintf(text) {
    var i=1, args=arguments;
    return text.replace(/%s/g, function() {
        return (i < args.length) ? args[i++] : "";
    });
}
// usage
var result = sprintf(templateText, "/item/4", "Fourth item");
```

3、复杂客户端模板； 比如使用 Handlebars
```
// 模板放在 script 中
<script type="text/x-handlebars-template" id="list-item">
    <li><a href="{{url}}">{{text}}</a></li>
</script>

function addItem(url, text) {
    var mylist = document.getElementById("mylist"),
    script = document.getElementById("list-item"),
    templateText = script.text,
    template = Handlebars.compile(script.text),
    div = document.createElement("div"),
    result;

    result = template({
        text: text,
        url: url
    });

    div.innerHTML = result;
    list.appendChild(div.firstChild);
}

// 使用
addItem("/item/4", "Fourth item");
```
## 第六章 避免使用全局变量
避免使用全局变量，存在问题：命名冲突；代码的脆弱性；难以测试

意外的全局变量：忘了var;  解决办法： 使用 JSLint 或者 JSHint ;

单全局变量： 比如YUI定义了一个YUI全局变量； jQuery 定义了两个全局变量，$ 和 jQuery;

命名空间： 比如 YUI.event 下的所有方法都是和事件相关的。

模块： AMD模块 和 YUI 模块；

```
// AMD    
define("my-books", [ "dependency1", "dependency2" ],
     function(dependency1, dependency2) {
          var Books = {};
          Books.MaintainableJavaScript = {
          author: "Nicholas C. Zakas"
     };
    return Books;
  });
```
零全局变量：使用前提是内部代码与外部代码无联系。
```
    (function(win) {
        var doc = win.document;

    })(window)
```    

## 第七章 事件处理
事件处理典型用法
```
// 不好的
function handleClick(event) {
    var popup = document.getElementById("popup");
    popup.style.left = event.clientX + "px";
    popup.style.top = event.clientY + "px";
    popup.className = "reveal";
}

// addListener() from Chapter 7
addListener(element, "click", handleClick);
```

规则1： 隔离应用逻辑
```
// 好的 - separate application logic
var MyApplication = {
    handleClick: function(event) {
        this.showPopup(event);
    },
    showPopup: function(event) {
        var popup = document.getElementById("popup");
        popup.style.left = event.clientX + "px";
        popup.style.top = event.clientY + "px";
        popup.className = "reveal";
    }
};

addListener(element, "click", function(event) {
    MyApplication.handleClick(event);
});
```

规则2： 不要分发事件对象；上面存在的问题是event 事件被无节制分发。从匿名事件处理函数到另一个函数，再到另一个函数。
最佳方法： 让事件处理程序使用event对象处理事件，然后拿到所有需要的数据传给应用逻辑。
```
// Good
var MyApplication = {
    handleClick: function(event) {
        this.showPopup(event.clientX, event.clientY);
    },
    showPopup: function(x, y) {
        var popup = document.getElementById("popup");
        popup.style.left = x + "px";
        popup.style.top = y + "px";
        popup.className = "reveal";
    }
};
addListener(element, "click", function(event) {
    MyApplication.handleClick(event); // this is okay
});
```
当处理事件时候，最好让事件处理程序成为接触到event对象的唯一的函数。
```
// Good
var MyApplication = {
    handleClick: function(event) {
        // assume DOM Level 2 events support
        event.preventDefault();
        event.stopPropagation();
        // pass to application logic
        this.showPopup(event.clientX, event.clientY);
    },
    showPopup: function(x, y) {
        var popup = document.getElementById("popup");
        popup.style.left = x + "px";
        popup.style.top = y + "px";
        popup.className = "reveal";
    }
};
addListener(element, "click", function(event) {
    MyApplication.handleClick(event); // this is okay
});
```
## 第八章 避免 “空比较“
下面是不好的示范，你很多都与null不相等，包括数字，字符串，对象等，从而带来隐藏的错误。
只有当期待的值是null的时候，可以和null进行比较。
```
var Controller = {
    process: function(items) {
        if (items !== null) { // Bad
            items.sort();
            items.forEach(function(item) {
                // do something
            });
        }
    }
};
```

检测基本类型使用typeof, 引用类型使用instanceof， 还有一种鸭式辨型，采用对象特有的方法或者属性是否存在来判断，例如array.sort(), 正则的test方法。通用的方法是，其他类型类似：
```
function isArray(value) {
    return Object.prototype.toString.call(value) === "[object Array]";
}
```

检测属性，判断属性最好的办法是用in
```
// 不好，当属性值是0, "", false, null或者 undefined 
if (object[propertyName]) {
    // do something
}

// Bad: Compare against null
if (object[propertyName] != null) {
    // do something
}

// Bad: Compare against undefined
if (object[propertyName] != undefined) {
    / do something
}

var object = {
    count: 0,
    related: null
};

// Good
if ("count" in object) {
    // this executes
}
if ("related" in object) {
    // this executes
}

//当你只想检查实例对象的某个属性是否存在的时候使用hasOwnProperty()
// Good for all non-DOM objects
if (object.hasOwnProperty("related")) {
    //this executes
}
// Good when you're not sure
if ("hasOwnProperty" in object && object.hasOwnProperty("related")) {
    //this executes
}
```
## 第九章 将配置数据从代码中分离出来
什么是配置数据？ 就是JavaScript代码中有可能发生改变的。

比如：url, 需要展现给用户的字符串， 重复的值， 设置， 任何可能发生变化的值。下面是不好的实例，其中的 invalid value, href的值， selcted 都是配置数据。
```
// Configuration data embedded in code
function validate(value) {
    if (!value) {
        alert("Invalid value");
        location.href = "/errors/invalid.php";
    }
}
function toggleSelected(element) {
    if (hasClass(element, "selected")) {
        removeClass(element, "selected");
    } else {
        addClass(element, "selected");
    }
}
```
 
抽离配置数据
```
// Configuration data externalized
var config = {
    MSG_INVALID_VALUE: "Invalid value",
    URL_INVALID: "/errors/invalid.php",
    CSS_SELECTED: "selected"
};
function validate(value) {
    if (!value) {
        alert(config.MSG_INVALID_VALUE);
        location.href = config.URL_INVALID;
    }
}
function toggleSelected(element) {
    if (hasClass(element, config.CSS_SELECTED)) {
        removeClass(element, config.CSS_SELECTED);
    } else {
        addClass(element, config.CSS_SELECTED);
    }
}
```

## 第十章 抛出自定义错误
推荐在错误消息中包含函数名称，以及函数失败的原因。
```
function getDivs(element) {
    if (element && element.getElementsByTagName) {
        return element.getElementsByTagName("div");
    } else {
        throw new Error("getDivs(): Argument must be a DOM element.");
    }
}
```
 何时抛出错误? 辨别代码中哪些部分在特定的情况下最优可能导致失败，并只在哪些地方抛出错误才是关键所在。我们的目的不是防止错误，而是错误发生的时候更加容易地调试。
```
// 不好的，太多检查
function addClass(element, className) {
    if (!element || typeof element.className != "string") {
        throw new Error("addClass(): First argument must be a DOM element.");
    }
    if (typeof className != "string") {
        throw new Error("addClass(): Second argument must be a string.");
    }
    element.className += " " + className;
}
// 好的写法  第二个参数是null 或者一个数字或者一个布尔值时是不会抛出错误的
function addClass(element, className) {
    if (!element || typeof element.className != "string") {
        throw new Error("addClass(): First argument must be a DOM element.");
    }
    element.className += " " + className;
}
```

 使用try catch 语句，当在try中 发生一个错误，会立即跳到catch语句，传入一个错误对象。还可以增加一个finally 模块，不管错误发不发生都会执行。
```
try {
    somethingThatMightCauseAnError();
} catch (ex) {
    handleError(ex);
} finally {
    continueDoingOtherStuff();
}
```

## 第十一章 不是你的对象不要动
以下这些对象不要尝试去修改他们，因为他们已经存在了： 原生对象（Object, Array）, DOM对象（document）, 浏览器对象模型（BOM）对象（window）, 类库的对象。 对待他们的原则是：不覆盖方法； 不新增方法； 不删除方法； 下面是一些不好的示例：
```
document.getElementById = function() {
    return null; // talk about confusing
};

document._originalGetElementById = document.getElementById;
document.getElementById = function(id) {
    if (id == "window") {
        return window;
    } else {
        return document._originalGetElementById(id);
    }
};

document.sayImAwesome = function() {
    alert("You're awesome.");
};

Array.prototype.reverseSort = function() {
    return this.sort().reverse();
};

YUI.doSomething = function() {
    // code
};

document.getElementById = null;
```
 更好的途径：有三种，见代码

```
//基于对象的继承
var person = {
    name: "Nicholas",
    sayName: function() {
    alert(this.name);
}
};
var myPerson = Object.create(person);
myPerson.sayName(); // pops up "Nicholas"

//基于类型的继承
function MyError(message) {
    this.message = message;
}
MyError.prototype = new Error();
var error = new MyError("Something bad happened.");
console.log(error instanceof Error); // true
console.log(error instanceof MyError); // true

//门面模式  与适配器唯一不同是 其创建新的接口，后者实现已经存在的接口
function DOMWrapper(element) {
    this.element = element;
}
DOMWrapper.prototype.addClass = function(className) {
    this.element.className += " " + className;
};
DOMWrapper.prototype.remove = function() {
    this.element.parentNode.removeChild(this.element);
};

// Usage
var wrapper = new DOMWrapper(document.getElementById("my-div"));

// add a CSS class
wrapper.addClass("selected");

// remove the element
wrapper.remove();
```
## 第十二章 浏览器嗅探
User-agent 检测
```
// Bad
if (navigator.userAgent.indexOf("MSIE") > -1) {
    // it's Internet Explorer
} else {
    // it's not
}

// good 不要试图检测IE 9及其高版本，而应该只检测IE8以及之前的
if (isInternetExplorer8OrEarlier) {
    // handle IE8 and earlier
} else {
    // handle all other browsers
}
```

特性检测，推荐使用特性检测
```
// Bad
if (navigator.userAgent.indexOf("MSIE 7") > -1) {
    // do something
}

// Good
if (document.getElementById) {
    // do something
}
```

避免特性推断
```
// Bad - uses feature inference
// 不能从一个特性推断出另一个特性是否存在
function getById (id) {
    var element = null;
    if (document.getElementsByTagName) { // DOM
        element = document.getElementById(id);
    } else if (window.ActiveXObject) { // IE
        element = document.all[id];
    } else { // Netscape <= 4
        element = document.layers[id];
    }
    return element;
}
```

避免浏览器推断，你不能根据某种方法存在就判定是某一种浏览器
```
// Bad
if (document.all) { // IE
    id = document.uniqueID;
} else {
    id = Math.random();
}

var isIE = !!document.all;

var isIE = !!document.all && document.uniqueID;
```
后面的章节是另一部分，比如文件目录，自动化啊等，不好总结。
