<?php

require '../vendor/autoload.php';

//start session to keep old form values and flash error messages
session_start();

use \App\Controllers\PagesController;

//set configuration to display errors or not
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

//initialize Slim application
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

//call container
require '../app/container.php';
$container = $app->getContainer();

// Add Middleware
$app->add(new \App\Middlewares\DatasMiddleware($container->view->getEnvironment(), $container->db));
$app->add(new \App\Middlewares\FlashMiddleware($container->view->getEnvironment()));
$app->add(new \App\Middlewares\OldMiddleware($container->view->getEnvironment()));
$app->add(new \App\Middlewares\TwigCsrfMiddleware($container->view->getEnvironment(), $container->csrf));
$app->add($container->csrf);

//Configure Routers
$app->get('/', PagesController::class . ':home')->setName('root');

$app->get('/cities', PagesController::class . ':getCities')->setName('cities');
$app->post('/cities', PagesController::class . ':postCities');

$app->get('/stations', PagesController::class . ':getStations')->setName('stations');
$app->post('/stations', PagesController::class . ':postStations');

//api routers
$app->get('/api/cities', PagesController::class . ':displayCities');
$app->get('/api/stations/{cityid}', PagesController::class . ':displayStations');


$app->run();