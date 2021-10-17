<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Router;

/** @var $router Router */

$router->name('home')->get ('/', function () {
    return 'hello world!';
});

$router->get('bye', function () {
    return 'goodbye world!';
});

$router->group(['namespace' => 'App\Api\Controllers', 'prefix' => 'api'], function (Router $router) {
    $router->get('/todo', ['name' => 'todo.index', 'uses' => 'ToDoController@index']);
});


// catch-all route
$router->any('{any}', function () {
    return 'four oh four';
})->where('any', '(.*)');
