<?php

/**
 * Index Front Controller
 *
 * @noinspection DuplicatedCode                        - Front controller shares code with other example front controllers, ignore.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpFullyQualifiedNameUsageInspection  - Ignore.
 * @noinspection PhpUnhandledExceptionInspection       - Allow unhandled exceptions to fall through the front controller.
 */

// Turn on strict types
declare(strict_types=1);


use Pith\Framework\PithException;


// Switch folders
chdir('../../../'); // <---- 1) Switch to whatever folder you want to run the App from.


// Error logging
ini_set('log_errors', '1');
ini_set('error_log', './php_errors.log'); // <---- 2) Add location of where you want the error log to be


// Auto-Load
$autoloader = require 'vendor/autoload.php'; // Enter the path to autoload.php, from the folder you're running the App from.


// Setup our Container
$container = new DI\Container(); // We're using PHP-DI by default. You can put your own container object here (Needs to be PSR-11 compatible plus auto-wiring support to run Pith).


// Load Pith
$pith = null;
try {
    // Pith Framework App
    $pith = $container->get('\\Pith\\Framework\\PithApp'); // Pith Framework App. If you make a fork, put the fork's App object here.
} catch (\DI\DependencyException $exception) {
    throw new PithException(
        'Pith Framework Exception 5002: The container encountered a \DI\DependencyException exception. Message: ' . $exception->getMessage(),
        5002,
        $exception
    );
} catch (\DI\NotFoundException $exception) {
    throw new PithException(
        'Pith Framework Exception 5001: The container encountered a \DI\NotFoundException exception. Message: ' . $exception->getMessage(),
        5001,
        $exception
    );
}

if($pith) {
    // Setup the logger
    // We're using Monolog here. You can use your own logger here instead of Monolog if you want. (Needs to be PSR-3 compatible)
    $monolog = new \Monolog\Logger('Pith');
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
    $pith->autoloader = $autoloader; // Give the autoloader to our App.
    $pith->container = $container; // Give the container (PHP-DI) to our App
    $pith->log = $monolog; // Give the logger (Monolog) to our App.

    // Add env constants to config
    $pith->config->env_constants_file = './src/shared-infrastructure/env.php'; // <---- 3) Set the env constants filepath here

    // Add other constants to config
    $pith->config->tracked_constants_file = './src/shared-infrastructure/tracked-constants.php'; // <---- 4) Set the tracked constants filepath here

    // Add route list to config
    $pith->config->route_list_namespace = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructureRouteList'; // <---- 5) Add namespace of your Route List here

    // Start
    $pith->engine->start();
}

