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

const PITH_DEV_ACCESS_IP_ADDRESSES  = [];
const PITH_CRON_ACCESS_IP_ADDRESSES = [];

const PITH_IMPRESSION_LOG_ENABLE = true;
const PITH_COMMAND_TASK_LOG_ENABLE = true;
const PITH_COMMAND_TASK_OUTPUT_LOG_ENABLE = true;

// For example, on Local Mac it would be:
// '/usr/local/bin/php /Users/{YOUR USER HERE}/{PATH TO}/pith-framework/task run %s %s 1>> /dev/null 2>&1'
const PITH_TASK_SHELL_COMMAND_FORMAT = '';

const PITH_EMAIL_ADAPTER_NAMESPACE              = '\\Pith\\PhpmailerEmailAdapter\\PithPhpmailerEmailAdapter';
const PITH_EMAIL_SMTP_HOST                      = 'smtp.example.com';
const PITH_EMAIL_ENABLE_SMTP_AUTHENTICATION     = true;
const PITH_EMAIL_SMTP_USERNAME                  = 'user@example.com';
const PITH_EMAIL_SMTP_PASSWORD                  = '';
const PITH_EMAIL_ENABLE_IMPLICIT_TLS            = true;
const PITH_EMAIL_SMTP_PORT                      = 465;
const PITH_EMAIL_ENABLE_VERBOSE_DEBUGGING       = true;
const PITH_EMAIL_TEST_TO_ADDRESS                = 'user@example.com';
const PITH_EMAIL_SYSTEM_FROM_ADDRESS            = 'noreply@example.com';
const PITH_EMAIL_SYSTEM_FROM_NAME               = 'No Reply';