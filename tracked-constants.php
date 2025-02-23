<?php

/**
 * Tracked Constants
 * -----------------
 *
 * This is the place for constants that should be viewable and tracked by Git.
 *
 * @noinspection PhpConstantNamingConventionInspection - Long constant names are ok.
 */

// Turn on strict types
declare(strict_types=1);

// Make sure STDOUT is defined
if(!defined('STDOUT')){
    define('STDOUT', fopen('php://stdout', 'wb'));
}

// Define our Constants

const PITH_APP_ROUTE_LIST = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructureRouteList';

const PITH_DEMO_PAGE_MAIN_TITLE            = 'Demo Page - Pith Framework';
const PITH_DEMO_PAGES_ROUTE_GROUP_PATH     = '/1111/1111/demo';
const PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH = '/2222/2222/env-info';
const PITH_USER_SYSTEM_AJAX_ENDPOINTS_PATH = '/ajax/user-system';

const PITH_IMPRESSION_LOG_LOCATION = 'logs/impressions-log/';
const PITH_TASK_LOG_LOCATION = 'logs/task-log/';
const PITH_TASK_OUTPUT_LOG_LOCATION = 'logs/task-output-log/';
const PITH_PHP_ERROR_LOG_LOCATION = 'logs/php-error-logs/';

const SHARED_UI_USER_LOGIN_FORM_ACTION_LINK             = '/shared-ui/perform-login';
const SHARED_UI_USER_LOGIN_FORM_PAGE_LINK               = '/1111/1111/demo/login';
const SHARED_UI_USER_LOGIN_SUCCESS_LANDING_PAGE_LINK    = '/1111/1111/demo';
const SHARED_UI_USER_PERFORM_LOGOUT_LINK                = '/shared-ui/perform-logout';
const SHARED_UI_USER_LOGOUT_SUCCESS_LANDING_PAGE_LINK   = '/1111/1111/demo?logged-out=yes';
const SHARED_UI_USER_LOGOUT_FAILURE_LANDING_PAGE_LINK   = '/1111/1111/demo?logged-out=no';
const SHARED_UI_USER_CREATION_ON_SUCCESS_GOTO_PAGE_LINK = SHARED_UI_USER_LOGIN_FORM_PAGE_LINK;

const PITH_PANEL_PATH = '/3333/3333/panel';

const TASKS_URL_PATH   = '/shared-infrastructure/run/task';
const TASKS_ROUTE_LIST = '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\TasksRouteList';


const PITH_APP_TASK_WORKSPACES_LIST = '\\Pith\\Framework\\SharedInfrastructure\\Tasks\\TaskWorkspacesList';

// Cache paths
const PITH_LATTE_CACHE_PATH = './cache/latte-cache/';
const PITH_TOUCHSTONE_FOLDER_LOCATION = 'cache/touchstones/';

// Migration Paths,
// The first namespace is the default when generating new migrations
// The default can be overridden by specifying the namespace in the migration command
// Example: php mig migrations:generate --namespace=Pith\\Framework\\TestMigration
const PITH_MIGRATIONS_PATHS = [
    'Pith\\Framework\\Migration' => './migrations',
];