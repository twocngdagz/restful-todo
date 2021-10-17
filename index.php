<?php

/**
 * Illuminate/Routing
 *
 * @source https://github.com/illuminate/routing
 * @contributor Muhammed Gufran
 * @contributor Matt Stauffer
 * @contributor https://github.com/jwalton512
 * @contributor https://github.com/dead23angel
 */

require_once 'vendor/autoload.php';

use App\Middleware\Authenticated;
use App\Middleware\StartSession;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Pipeline;
use Illuminate\Routing\Router;


$capsule = new Manager;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'todo',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();


$container = new Container;

$request = Request::capture();
$container->instance('Illuminate\Http\Request', $request);

$events = new Dispatcher($container);
$router = new Router($events, $container);

$globalMiddleware = [
    StartSession::class,
];

$routeMiddleware = [
    'auth' => Authenticated::class,
];


foreach ($routeMiddleware as $key => $middleware) {
    $router->aliasMiddleware($key, $middleware);
}


require_once 'routes.php';

$response = (new Pipeline($container))
    ->send($request)
    ->through($globalMiddleware)
    ->then(function ($request) use ($router) {
        return $router->dispatch($request);
    });

$response->send();
