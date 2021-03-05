<?php

namespace App\Middleware;

use core\request\RequestInterface;

class UserMiddleWare
{
    public function handle(RequestInterface $request, \Closure $next)
    {
        echo "<hr/>user controller middleware 1<hr/>". PHP_EOL;
        $response = $next($request);
        echo "<hr/>user controller middleware 2<hr/>". PHP_EOL;
        return $response;
    }
}
