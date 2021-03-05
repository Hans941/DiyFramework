<?php
namespace App\middleware;

class WebMiddleWare
{
    public function handle($request,\Closure $next)
    {
        echo "<hr/>web middleware 1<hr/>". PHP_EOL;
        $response = $next($request);
        echo "<hr/>web middleware 2<hr/>". PHP_EOL;
        return $response;
    }
}