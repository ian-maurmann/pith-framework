<?php

/**
 * PostgreSQL Wrapper Test-Driver
 * ------------------------------
 *
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpMethodNamingConventionInspection - Long method names are ok.
 */

declare(strict_types=1);

namespace Pith\Framework\Plugin\TestDrive;

use Exception;
use IKM\CLI\CommandLineFormatter;
use IKM\CLI\CommandLineWriter;
use Pith\Framework\PithAbout;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\PithException;

/**
 * Class PostgresWrapperTestDriver
 */
class PostgresWrapperTestDriver
{
    protected CommandLineFormatter $formatter;
    protected CommandLineWriter $writer;

    public function __construct()
    {
        // Get CLI tools
        $this->writer = new CommandLineWriter();
        $this->formatter = new CommandLineFormatter();
    }

    public function getTestList(): array
    {
        return [
            'get-status',
            'try-connect-get-status',
        ];
    }

    /**
     * @throws PithException
     *
     * @noinspection PhpUnnecessaryCurlyVarSyntaxInspection - Curly braces are ok.
     */
    public function runTest(string $test_name): void
    {
        if($test_name === 'get-status'){
            $this->runGetStatus();
            //$this->runGetFramework();
        }
        elseif($test_name === 'try-connect-get-status'){
            $this->runTryConnectGetStatus();
            //$this->runGetFramework();
        }
        else{
            // Get CLI tools
            $writer = $this->writer;
            $format = $this->formatter;

            // Formatting codes
            $reset = $format->reset;
            $red   = $format->fg_bright_red;

            // Output problem to CLI
            $writer->writeLine("{$red}Unknown test name. Cannot test-drive this.{$reset}");
        }
    }

    /**
     * @throws PithException
     */
    public function runGetFramework(): void
    {
        // Get the App
        //$app_retriever = new PithAppRetriever();
        //$app = $app_retriever->getApp();

        // Get CLI writer
        $writer = $this->writer;

        // Get the About object
        $about = new PithAbout();

        $framework = $about->framework_name;

        // Output to CLI
        $writer->writeLine($framework);
    }

    /**
     * @throws PithException
     */
    public function runGetStatus(): void
    {
        // Get the App
        $app_retriever = new PithAppRetriever();
        $app = $app_retriever->getApp();

        // Get CLI writer
        $writer = $this->writer;

        $status = $app->pg->getStatus();

        // Output to CLI
        $writer->writeLine($status);
    }

    /**
     * @throws PithException
     */
    public function runTryConnectGetStatus(): void
    {
        // Get the App
        $app_retriever = new PithAppRetriever();
        $app = $app_retriever->getApp();

        // Get CLI writer and formatter
        $writer = $this->writer;
        $format = $this->formatter;
        $reset = $format->reset;
        $dark_yellow = $format->fg_dark_yellow;

        // Output to CLI
        $writer->writeLine($dark_yellow . 'Getting the status....' . $reset);

        // Get status
        $status = $app->pg->getStatus();

        // Output to CLI
        $writer->writeLine($status);

        // Output to CLI
        $writer->writeLine($dark_yellow . 'Trying to connect....' . $reset);

        $did_connect = $app->pg->connectOnce();

        $did_connect_yes_no = $did_connect ? 'yes' : 'no';

        // Output to CLI
        $message = 'Did connect? ' . $did_connect_yes_no;
        $writer->writeLine($message);

        // Output to CLI
        $writer->writeLine($dark_yellow . 'Getting the status....' . $reset);

        // Get status
        $status = $app->pg->getStatus();

        // Output to CLI
        $writer->writeLine($status);
    }
}