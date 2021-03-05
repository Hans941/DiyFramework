<?php
namespace App\Controller;

use App\Middleware\UserMiddleWare;
use Core\BaseController;
use Core\request\RequestInterface;

// 继承基础控制器
class UserController extends BaseController
{

    protected $middleware = [ // 这个控制器的中间件
        UserMiddleWare::class
    ];

    public function index(RequestInterface $request)
    {
        return [
          'method' => $request->getMethod(),
          'url' =>  $request->getUri()
        ];
    }

    public function index2()
    {

    }

}