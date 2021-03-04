<?php
require __DIR__.'/vendor/autoload.php';

use App\FileLog;
use App\MyInterface\Log;
use Core\Ioc;

//实例化IoC容器
$ioc = new Ioc();
$ioc->bind('App\MyInterface\Log', function(){return new FileLog();});
$ioc->bind('User', "App\User");
$user = $ioc->make('User');
$user->login();