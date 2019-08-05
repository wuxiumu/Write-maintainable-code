抽象工厂模式（Abstract Factory） 

## 1.1.1. 目的
在不指定具体类的情况下创建一系列相关或依赖对象。 

通常创建的类都实现相同的接口。 

抽象工厂的客户并不关心这些对象是如何创建的，它只是知道它们是如何一起运行的。

## 1.1.2. UML 图

![](/000-imgs/BMhC0s5JAh.png)

## 1.1.3. 代码

你可以在 [GitHub](https://github.com/domnikl/DesignPatternsPHP/tree/master/Creational/AbstractFactory) 上找到这个代码。

Product.php
```
<?php

namespace DesignPatterns\Creational\AbstractFactory;
interface Product
{
    public function calculatePrice(): int;
}
```

ShippableProduct.php
```
<?php

namespace DesignPatterns\Creational\AbstractFactory;
class ShippableProduct implements Product
{
    /**
     * @var float
     */
    private $productPrice;
    /**
     * @var float
     */
    private $shippingCosts;
    public function __construct(int $productPrice, int $shippingCosts)
    {
        $this->productPrice = $productPrice;
        $this->shippingCosts = $shippingCosts;
    }
    public function calculatePrice(): int
    {
        return $this->productPrice + $this->shippingCosts;
    }
}
```

DigitalProduct.php
```
<?php

namespace DesignPatterns\Creational\AbstractFactory;
class DigitalProduct implements Product
{
    /**
     * @var int
     */
    private $price;
    public function __construct(int $price)
    {
        $this->price = $price;
    }
    public function calculatePrice(): int
    {
        return $this->price;
    }
}
```

ProductFactory.php
```
<?php

namespace DesignPatterns\Creational\AbstractFactory;
class ProductFactory
{
    const SHIPPING_COSTS = 50;
    public function createShippableProduct(int $price): Product
    {
        return new ShippableProduct($price, self::SHIPPING_COSTS);
    }
    public function createDigitalProduct(int $price): Product
    {
        return new DigitalProduct($price);
    }
}
```

## 1.1.4. Test

Tests/AbstractFactoryTest.php

```
<?php

namespace DesignPatterns\Creational\AbstractFactory\Tests;
use DesignPatterns\Creational\AbstractFactory\DigitalProduct;
use DesignPatterns\Creational\AbstractFactory\ProductFactory;
use DesignPatterns\Creational\AbstractFactory\ShippableProduct;
use PHPUnit\Framework\TestCase;
class AbstractFactoryTest extends TestCase
{
    public function testCanCreateDigitalProduct()
    {
        $factory = new ProductFactory();
        $product = $factory->createDigitalProduct(150);
        $this->assertInstanceOf(DigitalProduct::class, $product);
    }
    public function testCanCreateShippableProduct()
    {
        $factory = new ProductFactory();
        $product = $factory->createShippableProduct(150);
        $this->assertInstanceOf(ShippableProduct::class, $product);
    }
    public function testCanCalculatePriceForDigitalProduct()
    {
        $factory = new ProductFactory();
        $product = $factory->createDigitalProduct(150);
        $this->assertEquals(150, $product->calculatePrice());
    }
    public function testCanCalculatePriceForShippableProduct()
    {
        $factory = new ProductFactory();
        $product = $factory->createShippableProduct(150);
        $this->assertEquals(200, $product->calculatePrice());
    }
}
```