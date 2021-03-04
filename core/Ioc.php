<?php
namespace Core;

class Ioc
{
    public $binding = [];

    public function bind($abstract, $concrete)
    {
        //这里为什么要返回一个closure呢？因为bind的时候还不需要创建User对象，所以采用closure等make的时候再创建FileLog;
        // $this->binding[$abstract]['concrete'] = function ($ioc) use ($concrete) {
        //     return $ioc->build($concrete);
        // };
        if(! $concrete instanceof \Closure) // 如果具体实现不是闭包  那就生成闭包
        {
            $concrete = function ($ioc) use ($concrete) {
                return $ioc->build($concrete);
            };
        } 
            
        $this->binding[$abstract]['concrete'] = $concrete; // 存到$binding大数组里面

    }

    public function make($abstract)
    {
        // 根据key获取binding的值
        $concrete = $this->binding[$abstract]['concrete'];
        return $concrete($this);
    }

    // 创建对象
    public function build($concrete) {
        $reflector = new \ReflectionClass($concrete);
        $constructor = $reflector->getConstructor();
        if(is_null($constructor)) {
            return $reflector->newInstance();
        }else {
            $dependencies = $constructor->getParameters();
            $instances = $this->getDependencies($dependencies);
            return $reflector->newInstanceArgs($instances);
        }
    }

    // 获取参数的依赖
    protected function getDependencies($paramters) {
        $dependencies = [];
        foreach ($paramters as $paramter) {
            $dependencies[] = $this->make($paramter->getClass()->name);
        }
        return $dependencies;
    }

}
