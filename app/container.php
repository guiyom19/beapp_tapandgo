<?php

//load db config
require_once('db_config.php');

// Get container
$container = $app->getContainer();

//active debug mode
$container['debug'] = function () 
{
	return true;
};

// Register CSRF component on container (to secure form)
$container['csrf'] = function () 
{
	return new \Slim\Csrf\Guard;

};

// Register view component on container (twig)
$container['view'] = function ($container) 
{

	$dir = dirname(__DIR__);

    $view = new \Slim\Views\Twig($dir . '/app/views', [
        'cache' => $container->debug ? false : $dir . '/tmp/cache',
        'debug' => $container->debug
    ]);

    $view->addExtension(new Twig_Extension_Debug());
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

//PDO to connect MySQL Database
$container['pdo'] = function ()
{
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
    $driver_options = array
    (
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    );
    $pdo = new PDO($dsn, DB_USER, DB_PWD, $driver_options);

	return $pdo;
};

// Register DB component on container (Database Class)
$container['db'] = function ($container)
{
	return new \App\Classes\Database($container);
};