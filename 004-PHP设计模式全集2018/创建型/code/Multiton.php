
<?php 
abstract class Multiton { 
    private static $instances = array(); 
    public static function getInstance() { 
        $key = get_called_class() . serialize(func_get_args()); 
        if (!isset(self::$instances[$key])) { 
            $rc = new ReflectionClass(get_called_class()); 
            self::$instances[$key] = $rc->newInstanceArgs(func_get_args()); 
        } 
        return self::$instances[$key]; 
    } 
} 

class Hello extends Multiton { 
    public function __construct($string = 'World') { 
        echo "Hello $string\n"; 
    } 
} 

class GoodBye extends Multiton { 
    public function __construct($string = 'my', $string2 = 'darling') { 
        echo "Goodbye $string $string2\n"; 
    } 
} 

$a = Hello::getInstance('World'); 
$b = Hello::getInstance('bob'); 
// $a !== $b 

$c = Hello::getInstance('World'); 
// $a === $c 

$d = GoodBye::getInstance(); 
$e = GoodBye::getInstance(); 
// $d === $e 

$f = GoodBye::getInstance('your'); 
// $d !== $f 

// 可以看到PHP多例模式需要getInstance()传递关键值，
// 对于给定的关键值，
// PHP多例模式只会存在唯一的对象实例，
// PHP多例模式节省内存，
// 确保同一个对象的多个实例不发生冲突。
?>
