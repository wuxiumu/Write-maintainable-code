<?php
//对象池可以用于构造并且存放一系列的对象并在需要时获取调用（类似注册台模式）：
class Product {
 
    protected $id;
 
    public function __construct($id) {
        $this->id = $id;
    }
 
    public function getId() {
        return $this->id;
    }
}
 
class Factory {
 
    protected static $products = array();
 
    public static function pushProduct(Product $product) {
        self::$products[$product->getId()] = $product;
    }
 
    public static function getProduct($id) {
        return isset(self::$products[$id]) ? self::$products[$id] : null;
    }
 
    public static function removeProduct($id) {
        if (array_key_exists($id, self::$products)) {
            unset(self::$products[$id]);
        }
    }
}
 
 
Factory::pushProduct(new Product('first'));
Factory::pushProduct(new Product('second'));
 
print_r(Factory::getProduct('first')->getId());
// first
print_r(Factory::getProduct('second')->getId());
// second