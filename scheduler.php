<?php
// scheduler.php
// See https://github.com/peppeocchi/php-cron-scheduler


require_once __DIR__.'/vendor/autoload.php';

use GO\Scheduler;


// Create a new scheduler
$scheduler = new Scheduler();


// ... configure the scheduled jobs ...
$scheduler->raw('touch scheduler_was_run.txt')->everyMinute();


// Let the scheduler execute jobs which are due.
$scheduler->run();