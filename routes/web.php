<?php

$router->get('/hello', function () {
    return 'hello you';
});

$router->get('/config', function () {
    return config('database');
});

$router->get('/user', 'UserController@index');