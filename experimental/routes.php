<?php

/**
 * Routes
 */

// Turn on strict types
declare(strict_types=1);

// Define our App Routes
const APP_ROUTES = [
    ['GET', '/',                          '\\Pith\\ExampleAirshipPack\\IndexRoute'],
    ['GET', '/airship/hindenburg',        '\\Pith\\ExampleAirshipPack\\HindenburgRoute'],
    ['GET', '/jello',                     '\\Pith\\ExampleAirshipPack\\JelloRoute'],
    ['GET', '/library/foo/{filepath:.+}', '\\Pith\\ExampleResourcePack\\FooResourceRoute'],
];