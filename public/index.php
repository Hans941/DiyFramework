<?php
require __DIR__.'/../vendor/autoload.php';
require_once  __DIR__.'/../app.php';

App::getContainer()->bind('str',function (){
    return 'hello str';
});

echo App::getContainer()->get('str');