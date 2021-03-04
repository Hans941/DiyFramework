<?php
namespace App\middleware;

class WebMiddleWare
{
    public function handle($request,\Closure $next)
    {
        echo "web middleware" . PHP_EOL;
        return $next($request);
    }
}