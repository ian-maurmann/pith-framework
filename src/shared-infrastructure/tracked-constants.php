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

// Define our Constants
const PITH_DEMO_PAGE_MAIN_TITLE            = 'Demo Page - Pith Framework';
const PITH_DEMO_PAGES_ROUTE_GROUP_PATH     = '/1111/1111/demo';
const PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH = '/2222/2222/env-info';
const PITH_USER_SYSTEM_AJAX_ENDPOINTS_PATH = '/ajax/user-system';

const SHARED_UI_USER_LOGIN_FORM_ACTION_LINK           = '/shared-ui/perform-login';
const SHARED_UI_USER_LOGIN_FORM_PAGE_LINK             = '/1111/1111/demo/login';
const SHARED_UI_USER_LOGIN_SUCCESS_LANDING_PAGE_LINK  = '/1111/1111/demo';
const SHARED_UI_USER_PERFORM_LOGOUT_LINK              = '/shared-ui/perform-logout';
const SHARED_UI_USER_LOGOUT_SUCCESS_LANDING_PAGE_LINK = '/1111/1111/demo?logged-out=yes';
const SHARED_UI_USER_LOGOUT_FAILURE_LANDING_PAGE_LINK = '/1111/1111/demo?logged-out=no';