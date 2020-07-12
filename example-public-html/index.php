<?php

// Example Index / Front Controller
// --------------------------------

// Switch folders
chdir('../'); // Switch to whatever folder you want to run the App from.


// Auto-Load
require 'vendor/autoload.php'; // Enter the path to autoload.php, from the folder you're running the App from.


// Setup our Container
$php_di_container = new DI\Container(); // We're using PHP-DI for default. You can put your own container object here (Needs to be PSR-11 compatible plus autowiring support to run Pith).


// Pith Framework App
$pith           = $php_di_container->get('\\Pith\\Framework\\PithApp');              // Pith Framework App. If you make a fork, put the fork's App object here.
$config_profile = $php_di_container->get('\\Pith\\ExampleConfig\\ExampleConfig');    // <--- Replace this with your own Config Profile object.
$route_list     = $php_di_container->get('\\Pith\\ExampleConfig\\ExampleRouteList'); // <--- Replace this with your own Route List object.


// Setup the logger
// We're using Monolog here. You can use your own logger here instead of Monolog if you want. (Needs to be PSR-3 compatible)
$monolog        = new \Monolog\Logger('Pith');
$monolog_stream = new \Monolog\Handler\StreamHandler('php://stdout', \Monolog\Logger::DEBUG);
$monolog_format = new \Monolog\Formatter\LineFormatter(
    null, // Format of message in log, default [%datetime%] %channel%.%level_name%: %message% %context% %extra%\n
    'D M d H:i:s Y', // Datetime format // 'Y-m-d H:i:s'
    true, // allowInlineLineBreaks option, default false
    true  // ignoreEmptyContextAndExtra option, default false
);
$monolog_stream->setFormatter($monolog_format);
$monolog->pushHandler($monolog_stream);


// Add objects to Pith
$pith->container = $php_di_container; // Give the container (PHP-DI) to our App
$pith->log = $monolog; // Give the logger (Monolog) to our App.


// Set the Config
$pith->config->setConfigByObject($config_profile);
$pith->config->setRouteListByObject($route_list);


// Run Pith
$pith->start();
