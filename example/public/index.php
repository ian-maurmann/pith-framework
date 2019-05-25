<?php


// Switch folders
chdir('../../');


// Auto-Load
require 'vendor/autoload.php';


// Container
$container = new DI\Container();


// Load Pith App
$app = $container->get('\\Pith\\Framework\\PithApp');
$app->container = $container;


// Set the Config
$app->config->setConfigByObject($app->container->get('Pith\\ExampleConfig\\ExampleConfig'));

// Set the Route List
$app->config->setRouteListByObject($app->container->get('Pith\\ExampleConfig\\ExampleRouteList'));

// Run App
$app->start();



