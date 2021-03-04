<?php
namespace core;


use Core\Request\RequestInterface;

Class RouteCollection
{

    protected $routes = []; // 所有路由存放
    protected $route_index = 0;  // 当前访问的路由

    public function getRoutes() // 获取所有路由
    {
        return $this->routes;
    }

    public $currGroup = []; // 当前组

    public function group($attributes = [],\Closure $callback)
    {
        $this->currGroup[] = $attributes;

        call_user_func($callback,$this);
        // $callback($this);  跟这个一样的效果
        // group的实现主要的这个$this  这个$this将当前状态传递到了闭包

        array_pop($this->currGroup);
    }


    // 增加/  如: GETUSER 改成 GET/USER
    protected function addSlash(& $uri)
    {
        return $uri[0] == '/' ? : $uri = '/'.$uri;
    }


    // 增加路由
    public function addRoute($method,$uri,$uses)
    {

        $prefix = ''; // 前缀
        $middleware = [];  // 中间件
        $namespace = ''; // 命名空间
        $this->addSlash($uri);
        foreach ($this->currGroup as $group){
            $prefix .= $group['prefix'] ?? false;
            if( $prefix) // 如果有前缀
                $this->addSlash($prefix);

            $middleware = $group['middleware'] ?? []; // 合并组中间件
            $namespace .= $group['namespace'] ?? ''; // 拼接组的命名空间
        }
        $method = strtoupper($method); // 请求方式 转大写
        $uri = $prefix .$uri;
        $this->route_index = $method . $uri; // 路由索引
        $this->routes[$this->route_index] = [ // 路由存储结构  用 GET/USER   这种方式做索引 一次性就找到了
            'method' => $method,  // 请求类型
            'uri' => $uri,  // 请求url
            'action' => [
                'uses' => $uses,
                'middleware' => $middleware,
                'namespace' => $namespace
            ]
        ];
    }


    public function get($uri,$uses)
    {
        $this->addRoute('get',$uri,$uses);
        return $this;
    }


    public function post($uri,$uses)
    {
        $this->addRoute('post',$uri,$uses);
        return $this;
    }

    public function put($uri,$uess){} // 略写 ...
    public function delete($uri,$uses){}

    public function middleware($class)
    {
        $this->routes[$this->route_index]['action']['middleware'][] = $class;
        return $this;
    }

    // 获取当前访问的路由
    public function getCurrRoute()
    {
        $routes = $this->getRoutes();
        $route_index = $this->route_index;

        if( isset( $routes[ $route_index]))
            return  $routes[ $route_index];

        $route_index .= '/';

        if( isset( $routes[ $route_index]))
            return  $routes[ $route_index];
        return  false;
    }


    // 更具request执行路由
    public function dispatch(RequestInterface $request)
    {

        $method = $request->getMethod();
        $uri = $request->getUri();
        $this->route_index = $method . $uri;

        $route = $this->getCurrRoute();
        if(! $route) // 找不到路由
            return 404;
        
        // $routerDispatch = $route['action']['uses'];
        // return $routerDispatch();

        $middleware = $route['action']['middleware'] ?? [];
        $routerDispatch = $route['action']['uses'];
        return app('pipeline')->create()->setClass(
            $middleware
        )->run($routerDispatch)($request);


    }
}
