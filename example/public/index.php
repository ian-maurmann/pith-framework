<?php


# Switch folders
chdir('../../');


# Auto-Load
require 'vendor/autoload.php';


# Container
$container = new DI\Container();


// Load Pith App
$app = $container->get('\\Pith\\Framework\\PithApp');
$app->container = $container;


# Set the Config File
$app->config->setConfigFileLocation('example/config/config.php');


// Run App
$app->start();



