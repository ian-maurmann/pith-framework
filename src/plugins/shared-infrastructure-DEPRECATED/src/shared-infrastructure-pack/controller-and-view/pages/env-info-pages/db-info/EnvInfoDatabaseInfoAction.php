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

namespace Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages;

//use Pith\Framework\PithAction;
use Pith\Framework\SharedInfrastructure\Model\TestQuotes\TestQuoteService;
use Pith\Workflow\PithAction;

/**
 * Class EnvInfoDatabaseInfoAction
 * @package Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages
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
        // Get test quotes
        $quote_results              = $this->test_quote_service->getQuotes();

        // Get Variables using the new database
        $postgres_host          = PITH_POSTGRES_HOST;
        $postgres_port          = PITH_POSTGRES_PORT;
        $postgres_database_name = PITH_POSTGRES_DATABASE_NAME;
        $postgres_username      = PITH_POSTGRES_USERNAME;
     // $postgres_password      = PITH_POSTGRES_PASSWORD;
        $postgres_driver        = PITH_POSTGRES_DRIVER;
     // $postgres_dsn           = PITH_POSTGRES_DSN;

        // Push to Preparer
        $this->prepare->quote_results              = $quote_results;
        $this->prepare->postgres_host              = $postgres_host;
        $this->prepare->postgres_port              = $postgres_port;
        $this->prepare->postgres_database_name     = $postgres_database_name;
        $this->prepare->postgres_username          = $postgres_username;
     // $this->prepare->postgres_password          = $postgres_password;
        $this->prepare->postgres_driver            = $postgres_driver;
     // $this->prepare->postgres_dsn               = $postgres_dsn;
    }
}