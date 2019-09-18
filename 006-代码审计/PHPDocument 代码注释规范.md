# PHPDocument 代码注释规范

## 1. 安装phpDocumentor（不推荐命令行安装）

在http://manual.phpdoc.org/下载最新版本的PhpDoc

放在web服务器目录下使得通过浏览器可以访问到

点击files按钮，选择要处理的php文件或文件夹

还可以通过该指定该界面下的Files to ignore来忽略对某些文件的处理。

然后点击output按钮来选择生成文档的存放路径和格式.

最后点击create，phpdocumentor就会自动开始生成文档了。

## 2．如何写PHP规范注释

所有的文档标记都是在每一行的 * 后面以@开头。如果在一段话的中间出来@的标记，这个标记将会被当做普通内容而被忽掉。
```
@access        该标记用于指明关键字的存取权限：private、public或proteced 使用范围：class,function,var,define,module
@author        指明作者
@copyright    指明版权信息
@const        使用范围：define 用来指明php中define的常量
@final            使用范围：class,function,var 指明关键字是一个最终的类、方法、属性，禁止派生、修改。
@global        指明在此函数中引用的全局变量
@name            为关键字指定一个别名。
@package    用于逻辑上将一个或几个关键字分到一组。
@abstrcut    说明当前类是一个抽象类
@param        指明一个函数的参数
@return        指明一个方法或函数的返回值
@static            指明关建字是静态的。
@var            指明变量类型
@version        指明版本信息
@todo            指明应该改进或没有实现的地方
@link            可以通过link指到文档中的任何一个关键字
@ingore        用于在文档中忽略指定的关键字
```
一些注释规范
a.注释必须是
```
/**
* XXXXXXX
*/
```
的形式
b.对于引用了全局变量的函数，必须使用glboal标记。

c.对于变量，必须用var标记其类型（int,string,bool...）

d.函数必须通过param和return标记指明其参数和返回值

e.对于出现两次或两次以上的关键字，要通过ingore忽略掉多余的，只保留一个即可

f.调用了其他函数或类的地方，要使用link或其他标记链接到相应的部分，便于文档的阅读。

g.必要的地方使用非文档性注释（PHPDOC无法识别的关键字前的注释），提高代码易读性。

h.描述性内容尽量简明扼要，尽可能使用短语而非句子。

i.全局变量，静态变量和常量必须用相应标记说明

能够被phpdoc识别的关键字：
```
Include
Require
include_once
require_once
define
function
global
class
```

# 3. 规范注释的php代码 :
```
<?php
/**
* 文件名(sample2.php)
*
* 功能描述（略）
*
* @author steve <liuzhiqun@facedoing.com>
* @version 1.0
* @package sample2
*/

/**
* 包含文件
*/
include_once 'sample3.php';

/**
* 声明全局变量
* @global integer $GLOBALS['_myvar']
* @name $_myvar
*/
$GLOBALS['_myvar'] = 6;

/**
* 声明全局常量
*/
define('NUM', 6);

/**
* 类名
*
* 类功能描述
*
* @package sample2
* @subpackage classes(如果是父类 就添加)
*/
class myclass {

/**
* 声明普通变量
*
* @accessprivate
* @var integer|string
*/
var $firstvar = 6;

/**
* 创建构造函数 {@link $firstvar}
*/
function myclass() {
$this->firstvar = 7;
}

/**
* 定义函数
*
* 函数功能描述
*
* @global string $_myvar
* @staticvar integer $staticvar
* @param string $param1
* @param string $param2
* @return integer|string
*/
function firstFunc($param1, $param2 = 'optional') {
static $staticvar = 7;
global $_myvar;
return $staticvar;
}
}
?>
```