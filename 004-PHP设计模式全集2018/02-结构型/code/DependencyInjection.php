<?php
/**
 * @desc ：PHP依赖注入(DI)和容器(IoC)的简单实现
 */

namespace App;

use ReflectionClass;
use ReflectionParameter;

use Closure;

class Car
{
    public function driveCar($type = '法拉利')
    {
        return "人开{$type}";
    }
}

class PeoPle
{
    private $car;

    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    public function run($type)
    {
        return $this->car->driveCar($type);
    }
}

class Container
{
    /**
     *  容器绑定，用来装提供的实例或者 提供实例的回调函数
     * @var array
     */
    public $building = [];

    /**
     * 注册一个绑定到容器
     *
     * @param $abstract
     * @param null $concrete
     * @param bool $shared
     */
    public function bind($abstract, $concrete = null, $shared = false)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        if (!$concrete instanceOf Closure) {
            $concrete = $this->getClosure($abstract, $concrete);
        }
        $this->building[$abstract] = compact("concrete", "shared");
    }

    /**注册一个共享的绑定 单例
     *
     * @param $abstract
     * @param $concrete
     * @param bool $shared
     */
    public function singleton($abstract, $concrete, $shared = true)
    {
        $this->bind($abstract, $concrete, $shared);
    }

    /**
     * 默认生成实例的回调闭包
     *
     * @param $abstract
     * @param $concrete
     * @return Closure
     */
    public function getClosure($abstract, $concrete)
    {
        return function ($c) use ($abstract, $concrete) {
            $method = ($abstract == $concrete) ? 'build' : 'make';

            return $c->$method($concrete);
        };
    }

    /** 生成实例
     * 
     * @param $abstract
     * @return mixed|object
     */
    public function make($abstract)
    {
        var_dump($abstract);
        echo '--------' . PHP_EOL;
        $concrete = $this->getConcrete($abstract);
        if ($this->isBuildable($concrete, $abstract)) {
            $object = $this->build($concrete);
        } else {
            $object = $this->make($concrete);
        }

        return $object;
    }

    /**
     * 获取绑定的回调函数
     */
    public function getConcrete($abstract)
    {
        if (!isset($this->building[$abstract])) {
            return $abstract;
        }

        return $this->building[$abstract]['concrete'];
    }

    /**
     * 判断 是否 可以创建服务实体
     */
    public function isBuildable($concrete, $abstract)
    {
        return $concrete === $abstract || $concrete instanceof Closure;
    }

    /**
     * 根据实例具体名称实例具体对象
     */
    public function build($concrete)
    {
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        //创建反射对象
        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            //抛出异常
            throw new \Exception('无法实例化');
        }

        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();
        $instance = $this->getDependencies($dependencies);
        var_dump($instance);
        return $reflector->newInstanceArgs($instance);

    }

    //通过反射解决参数依赖
    public function getDependencies(array $dependencies)
    {
        $results = [];
        foreach ($dependencies as $dependency) {
            $results[] = is_null($dependency->getClass())
                ? $this->resolvedNonClass($dependency)
                : $this->resolvedClass($dependency);
        }

        return $results;
    }

    //解决一个没有类型提示依赖
    public function resolvedNonClass(ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }
        throw new \Exception('出错');

    }

    //通过容器解决依赖
    public function resolvedClass(ReflectionParameter $parameter)
    {
        return $this->make($parameter->getClass()->name);

    }

}

/**
 * 服务容器运行流程
 */

//实例化容器类
$app = new Container();
//向容器中填充Car
$app->bind('Car', 'App\Car');
//填充People
$app->bind('People', 'App\People');
//通过容器实现依赖注入，完成类的实例化；
$people = $app->make('People');
//调用方法
echo $people->run('保时捷') . PHP_EOL;


