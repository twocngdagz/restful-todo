<?php

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Hashing\HashManager;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

$configPath = __DIR__ . '/../config/';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$capsule = new Manager;

$capsule->addConnection(require $configPath . 'database.php');
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$config = new Repository(require $configPath . 'hashing.php');
$container = new Container;
Container::setInstance($container);

$container->instance('config', $config);


$hash = new HashManager($container);
$container->instance('hash', $hash);


$loader = new FileLoader(new Filesystem, 'lang');
$translator = new Translator($loader, 'en');
$validation = new Factory($translator, new Container);
$container->instance('validation', $validation);

return $container;
