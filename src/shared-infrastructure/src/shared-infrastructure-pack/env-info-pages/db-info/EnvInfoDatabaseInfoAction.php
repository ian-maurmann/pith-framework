<?php

/**
 * Env Info: Database Info Action
 * ------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithAction;

/**
 * Class EnvInfoDatabaseInfoAction
 * @package Pith\Framework\SharedInfrastructure
 */
class EnvInfoDatabaseInfoAction extends PithAction
{
    private TestQuoteService $test_quote_service;

    public function __construct(TestQuoteService $test_quote_service)
    {
        // Add Objects
        $this->test_quote_service = $test_quote_service;
    }

    public function runAction()
    {
        // Variables
        $quote_results              = $this->test_quote_service->getQuotes();
        $dsn                        = PITH_APP_DATABASE_DSN;
        $migrations_database_name   = PITH_DATABASE_MIGRATIONS_DATABASE_NAME;
        $migrations_database_host   = PITH_DATABASE_MIGRATIONS_DATABASE_HOST;
        $migrations_database_driver = PITH_DATABASE_MIGRATIONS_DATABASE_DRIVER;

        // Push to Preparer
        $this->prepare->quote_results              = $quote_results;
        $this->prepare->dsn                        = $dsn;
        $this->prepare->migrations_database_name   = $migrations_database_name;
        $this->prepare->migrations_database_host   = $migrations_database_host;
        $this->prepare->migrations_database_driver = $migrations_database_driver;
    }
}