<?php

/**
 * About Test-Driver
 * -----------------
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
 * Class AboutTestDriver
 */
class AboutTestDriver
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
            'get-framework',
            'get-copyright',
            'get-license',
            'get-release-status',
            'get-release-name',
            'get-real-version',
            'get-semver-version',
        ];
    }

    /**
     * @throws PithException
     *
     * @noinspection PhpUnnecessaryCurlyVarSyntaxInspection - Curly braces are ok.
     */
    public function runTest(string $test_name): void
    {
        if($test_name === 'get-framework'){
            $this->runGetFramework();
        }
        elseif($test_name === 'get-copyright'){
            $this->runGetCopyright();
        }
        elseif($test_name === 'get-license'){
            $this->runGetLicense();
        }
        elseif($test_name === 'get-release-status'){
            $this->runGetReleaseStatus();
        }
        elseif($test_name === 'get-release-name'){
            $this->runGetReleaseName();
        }
        elseif($test_name === 'get-real-version'){
            $this->runGetRealVersion();
        }
        elseif($test_name === 'get-semver-version'){
            $this->runGetSemverVersion();
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

    public function runGetCopyright(): void
    {
        // Get CLI writer
        $writer = $this->writer;

        // Get the About object
        $about = new PithAbout();

        $copyright = $about->copyright;

        // Output to CLI
        $writer->writeLine($copyright);
    }

    public function runGetLicense(): void
    {
        // Get CLI writer
        $writer = $this->writer;

        // Get the About object
        $about = new PithAbout();

        $license = $about->license;

        // Output to CLI
        $writer->writeLine($license);
    }

    public function runGetReleaseStatus(): void
    {
        // Get CLI writer
        $writer = $this->writer;

        // Get the About object
        $about = new PithAbout();

        $release_status = $about->release_status;

        // Output to CLI
        $writer->writeLine($release_status);
    }

    public function runGetReleaseName(): void
    {
        // Get CLI writer
        $writer = $this->writer;

        // Get the About object
        $about = new PithAbout();

        $release_name = $about->release_name;

        // Output to CLI
        $writer->writeLine($release_name);
    }

    public function runGetRealVersion(): void
    {
        // Get CLI writer
        $writer = $this->writer;

        // Get the About object
        $about = new PithAbout();

        $real_version = $about->real_version;

        // Output to CLI
        $writer->writeLine($real_version);
    }

    public function runGetSemverVersion(): void
    {
        // Get CLI writer
        $writer = $this->writer;

        // Get the About object
        $about = new PithAbout();

        $semver_version = $about->semver_version;

        // Output to CLI
        $writer->writeLine($semver_version);
    }
}