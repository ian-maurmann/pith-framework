<?php
// scheduler.php
// See https://github.com/peppeocchi/php-cron-scheduler


require_once __DIR__.'/vendor/autoload.php';

use GO\Scheduler;

// Error logging
ini_set('log_errors', '1');
ini_set('error_log', './php_errors.log');

error_log('scheduler run');
error_log(__DIR__);

chdir(__DIR__);

// Create a new scheduler
$scheduler = new Scheduler();


// ... configure the scheduled jobs ...
$scheduler->raw('touch scheduler_was_run.txt')->everyMinute();


// Let the scheduler execute jobs which are due.
$scheduler->run();