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


// For Debugging - Show all errors if need to debug before config
// ==============================================
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// ==============================================


// Auto-Load
require './vendor/autoload.php';

// Add env constants
require './env.php';

// Add other constants
require './tracked-constants.php';


// Error logging
ini_set('log_errors', '1');
$php_error_log_filename = './' . PITH_PHP_ERROR_LOG_LOCATION . 'php_errors_'. date('Y-m-d') .'.log';
ini_set('error_log', $php_error_log_filename);


// For Debugging - Make sure errors are being logged
// ============================
// error_log('Hello, errors!');
// ============================

// Set STDOUT if not already set
if(!defined('STDOUT')){
    define('STDOUT', fopen('php://stdout', 'wb'));
}

// Setup our Container
$container = new DI\Container();


// Load the Pith Dependency Injection Wrapper
$dependency_injection_wrapper = null;
try {
    // Pith Framework App
    $dependency_injection_wrapper = $container->get('\\Pith\\Framework\\PithDependencyInjection');
} catch (\DI\DependencyException $exception) {
    throw new PithException(
        'Pith Framework Exception 5009: The container encountered a \DI\DependencyException exception. Message: ' . $exception->getMessage(),
        5009,
        $exception
    );
} catch (\DI\NotFoundException $exception) {
    throw new PithException(
        'Pith Framework Exception 5008: The container encountered a \DI\NotFoundException exception. Message: ' . $exception->getMessage(),
        5008,
        $exception
    );
}

// Load Pith
$pith = null;
try {
    // Pith Framework App
    $pith = $dependency_injection_wrapper->container->get('\\Pith\\Framework\\PithApp');
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
    // Add route list to config
    $pith->config->route_list_namespace = PITH_APP_ROUTE_LIST;

    // Start
    //$pith->engine->start(); // Don't start yet
}

