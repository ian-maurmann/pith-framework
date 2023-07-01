<?php

/**
 * Constants
 *
 * (Just imagine how painfully inefficient it would be
 * to store all the constants inside the database... )
 *
 * @noinspection PhpConstantNamingConventionInspection - Long constant names are ok here.
 */

// Turn on strict types
declare(strict_types=1);

// Define our Constants
const PITH_APP_DATABASE_DSN           = '';
const PITH_APP_DATABASE_USER_USERNAME = '';
const PITH_APP_DATABASE_USER_PASSWORD = '';

const PITH_DATABASE_MIGRATIONS_DATABASE_NAME   = '';
const PITH_DATABASE_MIGRATIONS_DATABASE_HOST   = '';
const PITH_DATABASE_MIGRATIONS_DATABASE_DRIVER = '';

const PITH_DEV_ACCESS_IP_ADDRESSES = [];

const PITH_IMPRESSION_LOG_ENABLE   = true;
const PITH_IMPRESSION_LOG_LOCATION = 'logs/impressions-log/';