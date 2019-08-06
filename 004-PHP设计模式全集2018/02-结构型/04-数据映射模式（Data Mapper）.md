数据映射模式（Data Mapper）

## 2.4.1. 目标
数据映射器是一种数据访问层，它执行持久性数据存储（通常是关系数据库）和内存数据表示（域层）之间的数据双向传输。 

该模式的目标是保持内存表示和持久数据存储相互独立，并保持数据映射器本身。

 该层由一个或多个映射器（或数据访问对象）组成，执行数据传输。 

映射器实现的范围有所不同。 

通用映射器将处理许多不同的域实体类型，专用映射器将处理一个或几个。

这种模式的关键点在于，与活动记录模式不同，数据模型遵循单一责任原则。

## 2.4.2. 例子
数据库对象关系映射器（ ORM ）：Doctrine2 使用的 DAO，名字叫做 “EntityRepository”。

## 2.4.3. UML 图

![WHNWAjWM3i.png](/000-imgs/WHNWAjWM3i.png)

## 2.4.4. 代码
你能在 GitHub 上面找到这些代码

User.php
```
<?php

namespace DesignPatterns\Structural\DataMapper;

class User
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    public static function fromState(array $state): User
    {
        // 在你访问的时候验证状态

        return new self(
            $state['username'],
            $state['email']
        );
    }

    public function __construct(string $username, string $email)
    {
        // 先验证参数在设置他们

        $this->username = $username;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
```

UserMapper.php
```
<?php

namespace DesignPatterns\Structural\DataMapper;

class UserMapper
{
    /**
     * @var StorageAdapter
     */
    private $adapter;

    /**
     * @param StorageAdapter $storage
     */
    public function __construct(StorageAdapter $storage)
    {
        $this->adapter = $storage;
    }

    /**
     * 根据 id 从存储器中找到用户，并返回一个用户对象
     * 在内存中，通常这种逻辑将使用 Repository 模式来实现
     * 然而，重要的部分是在下面的 mapRowToUser() 中，它将从中创建一个业务对象
     * 从存储中获取的数据
     *
     * @param int $id
     *
     * @return User
     */
    public function findById(int $id): User
    {
        $result = $this->adapter->find($id);

        if ($result === null) {
            throw new \InvalidArgumentException("User #$id not found");
        }

        return $this->mapRowToUser($result);
    }

    private function mapRowToUser(array $row): User
    {
        return User::fromState($row);
    }
}
```

StorageAdapter.php
```
<?php

namespace DesignPatterns\Structural\DataMapper;

class StorageAdapter
{
    /**
     * @var array
     */
    private $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function find(int $id)
    {
        if (isset($this->data[$id])) {
            return $this->data[$id];
        }

        return null;
    }
}
```

## 2.4.5. 测试
Tests/DataMapperTest.php
```
<?php

namespace DesignPatterns\Structural\DataMapper\Tests;

use DesignPatterns\Structural\DataMapper\StorageAdapter;
use DesignPatterns\Structural\DataMapper\User;
use DesignPatterns\Structural\DataMapper\UserMapper;
use PHPUnit\Framework\TestCase;

class DataMapperTest extends TestCase
{
    public function testCanMapUserFromStorage()
    {
        $storage = new StorageAdapter([1 => ['username' => 'domnikl', 'email' => 'liebler.dominik@gmail.com']]);
        $mapper = new UserMapper($storage);

        $user = $mapper->findById(1);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWillNotMapInvalidData()
    {
        $storage = new StorageAdapter([]);
        $mapper = new UserMapper($storage);

        $mapper->findById(1);
    }
}
```

>其他

## 为什么要使用数据映射器？

数据映射器实现起来比前三种模式都要复杂，那为什么还要使用它呢？

对象间的组织关系和关系数据库中的表是不同的。

数据库表可以看成是由行与列组成的格子，表中的一行可以通过外键和另一个表（甚至同一个表）中的一行关联，而对象的组织关系更为复杂：一个对象可能包含其他对象；不同的数据结构可能通过不同的方式组织相同的对象。

对象和关系数据库之间的这种分歧被称为“对象关系阻抗不匹配”或“阻抗不匹配”。

数据映射器可以很好地解决这个问题，由它来负责对象和关系数据库两者数据的转换，从而有效地在领域模型中隐藏数据库操作并管理数据库转换中不可以避免的冲突。

## 使用时机

使用数据库映射器的主要是数据库方案和对象模型需要彼此独立演变的时候。最常见的当然是和领域模式一起使用。数据映射器无论是在设计阶段、开发阶段，还是测试阶段，在领域模型上操作时可以不考虑数据库。领域对象对数据库的结构一无所知，因为所有这些对应关系都由数据映射器完成。

当然，数据映射器引入了新的层次，因此使用这些模式的前提条件是业务逻辑的复杂性，如果很简单，那就没必要了。

如果没有领域模型，我不会选用数据映射器。但是没有数据映射器时，能使用领域模型吗？如果领域模型简单，且数据库受领域模型开发者的控制，则领域对象用活动记录直接访问数据库也是合理的。

不必创建完全意义上的数据库映射层。创建这样的数据映射器很复杂。大多数情况下，建议使用开源的数据库映射层而不是自己动手创建