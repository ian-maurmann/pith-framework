<?php
declare(strict_types=1);

// Include the Env Constants file
require_once 'env.php';

return [
    'dbname'   => PITH_DATABASE_MIGRATIONS_DATABASE_NAME,
    'user'     => PITH_APP_DATABASE_USER_USERNAME,
    'password' => PITH_APP_DATABASE_USER_PASSWORD,
    'host'     => PITH_DATABASE_MIGRATIONS_DATABASE_HOST,
    'driver'   => PITH_DATABASE_MIGRATIONS_DATABASE_DRIVER,
];