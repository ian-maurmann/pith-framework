<?php

/**
 * Index file
 * ──────────
 */

// Turn on strict types
declare(strict_types=1);

// Switch to App folder
chdir('../../'); // <---- Switch to whatever folder you want to run the App from.

// Run the App front controller
require 'front-controller.php';

// Get pith
global $pith;

// Start
$pith->engine->start();


