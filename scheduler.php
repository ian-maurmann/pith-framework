<?php
// scheduler.php
// See https://github.com/peppeocchi/php-cron-scheduler


require_once __DIR__.'/vendor/autoload.php';

use GO\Scheduler;


// Set folder
chdir(__DIR__);


// Error logging
ini_set('log_errors', '1');
ini_set('error_log', './php_errors.log');


// error_log('scheduler run');
// error_log(__DIR__);


// Create a new scheduler
$scheduler = new Scheduler();


// ... configure the scheduled jobs ...
//$scheduler->raw('touch scheduler_was_run.txt')->everyMinute();
//$scheduler->raw('curl --request GET "http://127.0.0.1:8080/shared-infrastructure/run/task/hello_task"')->everyMinute();
//$scheduler->raw('curl --request GET "http://127.0.0.1:8080/shared-infrastructure/run/task/hello_world"')->everyMinute();
//$scheduler->raw('curl --request GET "http://127.0.0.1:8080/shared-infrastructure/run/task/tick"')->everyMinute();

// Impression Logs
$scheduler->raw('curl --request GET "http://127.0.0.1:8080/shared-infrastructure/run/task/queue_impression_logs_for_import"')->hourly(5);
$scheduler->raw('curl --request GET "http://127.0.0.1:8080/shared-infrastructure/run/task/import_impression_log_to_database"')->everyMinute(7);
$scheduler->raw('curl --request GET "http://127.0.0.1:8080/shared-infrastructure/run/task/delete_loaded_impression_log"')->everyMinute(9);
$scheduler->raw('curl --request GET "http://127.0.0.1:8080/shared-infrastructure/run/task/cleanup_impression_log_loading_queue"')->hourly(2);
$scheduler->raw('curl --request GET "http://127.0.0.1:8080/shared-infrastructure/run/task/gather_unique_daily_views"')->hourly(22);


// Let the scheduler execute jobs which are due.
$scheduler->run();