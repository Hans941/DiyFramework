<?php
require __DIR__.'/../vendor/autoload.php';
require_once  __DIR__.'/../app.php';

use Core\Request\RequestInterface;

App::getContainer()->bind(RequestInterface::class, function () {
    return \Core\Request\PhpRequest::create($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'], $_SERVER);
});

echo app(RequestInterface::class)->getMethod(); # GET 