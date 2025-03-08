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

// Switch to App folder
chdir('../../repositories/your-project-here/'); // <---- 1) Switch to whatever folder you want to run the App from.

// Run the App front controller
require 'front-controller.php';

// Get Pith
global $pith;

// Start
$pith->engine->start();

