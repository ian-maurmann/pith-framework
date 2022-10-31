<?php

/**
 * .serve.php
 * ----------
 *
 * Provides routing for the PHP Built-in web server
 * https://www.php.net/manual/en/features.commandline.webserver.php
 *
 * Based on:
 * https://stackoverflow.com/questions/27381520/php-built-in-server-and-htaccess-mod-rewrites
 * Answer by Caleb in 2016
 *
 * To run:
 * $ php -S 127.0.0.1:8081 .serve.php
 *
 * @noinspection PhpIncludeInspection                  - Using include( ) is ok here.
 * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
 * @noinspection PhpUnhandledExceptionInspection       - Allow unhandled exceptions.
 * @noinspection PhpMethodNamingConventionInspection   - Short method names are ok.
 * @noinspection PhpRedundantCatchClauseInspection     - Exceptions are included.
 */

declare(strict_types=1);

use Pith\Framework\PithException;

chdir(__DIR__);

// ──────────────────────────────────────────────────────────

/**
 * Set STDOUT
 *
 * Based on:
 * https://stackoverflow.com/questions/17769041/notice-use-of-undefined-constant-stdout-assumed-stdout
 * Answer by Ronny Sherer in 2015
 */
if(!defined('STDOUT')){
    define('STDOUT', fopen('php://stdout', 'wb'));
}

// ──────────────────────────────────────────────────────────
// Console Color Codes
// see: https://en.wikipedia.org/wiki/ANSI_escape_code

$normal_console_text      = "\033[0m";
$red_console_text         = "\033[31m";
$purple_console_text      = "\033[35m";
$teal_console_text        = "\033[36m";
$yellow_console_text      = "\033[93m";
$bright_blue_console_text = "\033[94m";
$magenta_console_text     = "\033[95m";
$cyan_console_text        = "\033[96m";

// Get URI
$uri = $_SERVER['REQUEST_URI'];
// ──────────────────────────────────────────────────────────



/**
 *
 * Based on:
 *
 * https://stackoverflow.com/questions/14353767/print-something-in-php-built-in-web-server
 * Answer by Saif Eddin Gmati in 2018
 *
 * This is for development purpose ONLY !
 */
final class ServerLogger {

    /**
     * send a log message to the STDOUT stream.
     *
     * @param array<int, mixed> $args
     *
     * @return void
     */
    public static function log(...$args): void {
        foreach ($args as $arg) {
            if (is_object($arg) || is_array($arg) || is_resource($arg)) {
                $output = print_r($arg, true);
            } else {
                $output = (string) $arg;
            }

            fwrite(STDOUT, $output . "\n");
        }
    }
}

// ──────────────────────────────────────────────────────────


$message = "\033[103m" . "\033[30m" . 'Request' . $normal_console_text;
ServerLogger::log($message);

// ──────────────────────────────────────────────────────────

/**
 *
 * Based on:
 *
 * https://stackoverflow.com/questions/27381520/php-built-in-server-and-htaccess-mod-rewrites
 * Answer by Caleb in 2016
 *
 * This is for development purpose ONLY !
 */

$file_path = realpath(ltrim($_SERVER['REQUEST_URI'], '/'));
if ($file_path && is_dir($file_path)){
    // attempt to find an index file
    foreach (['index.php', 'index.html'] as $index_file){
        if ($file_path = realpath($file_path . DIRECTORY_SEPARATOR . $index_file)){ // intentional =
            break;
        }
    }
}
if ($file_path && is_file($file_path)) {
    // 1. check that file is not outside of this directory for security
    $is_in_folder = (strpos($file_path, __DIR__ . DIRECTORY_SEPARATOR) === 0);

    // 2. check for circular reference to router
    $is_not_circular_reference = ($file_path != __DIR__ . DIRECTORY_SEPARATOR . '.serve.php');

    // 3. don't serve dotfiles
    $is_not_dot_file = (substr(basename($file_path), 0, 1) != '.');

    if ($is_in_folder && $is_not_circular_reference && $is_not_dot_file) {
        if (strtolower(substr($file_path, -4)) == '.php') {


            $message = $teal_console_text . $uri . $normal_console_text;
            ServerLogger::log($message);

            // php file; serve through interpreter
            include $file_path;

            // Was served
            return true;
        } else {

            $message = $yellow_console_text . $uri . $normal_console_text;
            ServerLogger::log($message);

            // asset file; serve from filesystem
            return false;
        }
    } else {
        $message = $red_console_text . $uri . $normal_console_text;
        ServerLogger::log($message);

        // disallowed file
        header('HTTP/1.1 404 Not Found');
        echo '404 Not Found';
    }
} else {
    try {
        include __DIR__ . DIRECTORY_SEPARATOR . 'index.php';

        $message = $cyan_console_text . $uri . $normal_console_text;
        ServerLogger::log($message);
    }
    catch (PithException $exception) {
        $exception_number  = $exception->getCode();
        $exception_message = $exception->getMessage();

        /** @noinspection PhpIfWithCommonPartsInspection */
        if($exception_number === 4004 || $exception_number === 4022){
            $message = $red_console_text . $uri . $normal_console_text;
            ServerLogger::log($message);
        }
        else{
            $message = $magenta_console_text . $uri . $normal_console_text;
            ServerLogger::log($message);

            $message = $red_console_text . '-- Exception ' . $exception_number . ' ---- Exception Message: ' . $exception_message . $normal_console_text;
            ServerLogger::log($message);
        }

        throw $exception;
    } catch (Exception $exception) {
        $exception_number = $exception->getCode();
        $exception_message = $exception->getMessage();

        $message = $purple_console_text . $uri . $normal_console_text;
        ServerLogger::log($message);

        $message = $red_console_text . '-- Exception ' . $exception_number . ' ---- Exception Message: ' . $exception_message . $normal_console_text;
        ServerLogger::log($message);

        throw $exception;
    }
}



// ──────────────────────────────────────────────────────────

