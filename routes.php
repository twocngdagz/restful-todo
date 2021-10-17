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
    $router->post('/login', ['name' => 'user.login', 'uses' => 'AuthController@login']);
});

$router->group(['middleware' => 'auth'], function (Router $router) {
    $router->group(['namespace' => 'App\Api\Controllers', 'prefix' => 'api'], function (Router $router) {
        $router->get('/todos', ['name' => 'todo.index', 'uses' => 'ToDoController@index']);
        $router->get('/todos/{id}', ['name' => 'todo.show', 'uses' => 'ToDoController@show']);
        $router->post('/todos', ['name' => 'todo.create', 'uses' => 'ToDoController@create']);
        $router->patch('/todos/{todo}', ['name' => 'todo.update', 'uses' => 'ToDoController@update']);
        $router->delete('/todos/{todo}', ['name' => 'todo.delete', 'uses' => 'ToDoController@destroy']);
    });
});

// catch-all route
$router->any('{any}', function () {
    return 'four oh four';
})->where('any', '(.*)');
