流接口模式（Fluent Interface）

## 2.8.1. 目的
用来编写易于阅读的代码，就像自然语言一样（如英语）

## 2.8.2. 例子
Doctrine2 的 QueryBuilder，就像下面例子中类似

PHPUnit 使用连贯接口来创建 mock 对象

Yii 框架：CDbCommand 与 CActiveRecord 也使用此模式

## 2.8.3. UML 图

![K6NHRBLVHw.png](/000-imgs/K6NHRBLVHw.png)

## 2.8.4. 代码
你可以在 [GitHub](https://github.com/domnikl/DesignPatternsPHP/tree/master/Structural/FluentInterface) 上找到这些代码

Sql.php
```
<?php

namespace DesignPatterns\Structural\FluentInterface;

class Sql
{
    /**
     * @var array
     */
    private $fields = [];

    /**
     * @var array
     */
    private $from = [];

    /**
     * @var array
     */
    private $where = [];

    public function select(array $fields): Sql
    {
        $this->fields = $fields;

        return $this;
    }

    public function from(string $table, string $alias): Sql
    {
        $this->from[] = $table.' AS '.$alias;

        return $this;
    }

    public function where(string $condition): Sql
    {
        $this->where[] = $condition;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf(
            'SELECT %s FROM %s WHERE %s',
            join(', ', $this->fields),
            join(', ', $this->from),
            join(' AND ', $this->where)
        );
    }
}
```

## 2.8.5. 测试
Tests/FluentInterfaceTest.php
```
<?php

namespace DesignPatterns\Structural\FluentInterface\Tests;

use DesignPatterns\Structural\FluentInterface\Sql;
use PHPUnit\Framework\TestCase;

class FluentInterfaceTest extends TestCase
{
    public function testBuildSQL()
    {
        $query = (new Sql())
                ->select(['foo', 'bar'])
                ->from('foobar', 'f')
                ->where('f.bar = ?');

        $this->assertEquals('SELECT foo, bar FROM foobar AS f WHERE f.bar = ?', (string) $query);
    }
}
```
>其他

我最初接触这个概念是读自<<模式-工程化实现及扩展>>,

另外有Martin fowler大师 

所写http://martinfowler.com/bliki/FluentInterface.html

Fluent Interface实例

### Java 类Country
```
package com.jue.fluentinterface;  
  
  
public class Country {  
    private String name;  
    private int code;  
    private boolean isDevelopedCountry;  
    private int area;  
  
  
    Country addName(String name) {  
        this.name = name;  
        return this;  
    }  
  
  
    Country addCountyCode(int code) {  
        this.code = code;  
        return this;  
    }  
  
  
    Country setDeveloped(boolean isdeveloped) {  
        this.isDevelopedCountry = isdeveloped;  
        return this;  
    }  
  
  
    Country setAread(int area) {  
        this.area = area;  
        return this;  
    }  
}  
```

### 调用类
```
/** 
 * @param args 
 */  
public static void main(String[] args) {  
    // TODO Auto-generated method stub  
  
    Country china = new Country();  
    china.addName("The People's Republic of China")  
            .addCountyCode(1001)  
            .setDeveloped(false)  
            .setAread(960);  
}  
```
### 主要特征:

Country 的方法返回本身country，使调用者有了继续调用country方法的能力.

优势

1.有时候我们需要根据传入的参数数目不同定义不同的构造器。使用 FluentInterface就可以随意传递想要的数据，并保持他们的连贯。


java中的应用 

StringBuffer append方法