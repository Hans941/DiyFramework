<?php
require __DIR__.'/vendor/autoload.php';

use App\FileLog;
use App\MyInterface\Log;
use Core\Ioc;

//实例化IoC容器
$ioc = new Ioc();
#通过路径和闭包bind
$ioc->bind('App\MyInterface\Log', function($ioc){return new FileLog();});
#通过别名和路径bind
$ioc->bind('User', "App\User");
$user = $ioc->make('User');
$user->login();