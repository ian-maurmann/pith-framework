<?php

/**
 * Pith Test Driver Console
 * ------------------------
 *
 * @noinspection PhpMethodNamingConventionInspection - Short method names are ok.
 * @noinspection PhpClassNamingConventionInspection  - Long class name is ok.
 */

declare(strict_types=1);

namespace Pith\Framework\Plugin\CommandTool2;

use Exception;
use IKM\CLI\CommandLineFormatter;
use IKM\CLI\CommandLineWriter;
use Pith\Framework\PithException;
use Pith\Framework\Plugin\TestDrive\AboutTestDriver;

/**
 * Class PithTestDriverConsole
 */
class PithTestDriverConsole
{
    protected CommandLineFormatter $formatter;
    protected CommandLineWriter $writer;

    public function __construct()
    {
        // Get CLI tools
        $this->writer    = new CommandLineWriter();
        $this->formatter = new CommandLineFormatter();
    }

    /**
     * @noinspection PhpConditionAlreadyCheckedInspection - Ignore.
     * @noinspection PhpVariableNamingConventionInspection - Long variable names are ok.
     *
     * @throws PithException
     */
    public function testDrive(string $feature_name, string $test_name): void
    {
        // Check what params we have
        $has_feature_name = !empty($feature_name) && is_string($feature_name) && strlen($feature_name) > 0;
        $has_test_name = !empty($test_name) && is_string($test_name) && strlen($test_name) > 0;

        // Pick what mode to use
        $is_feature_list_mode = !$has_feature_name;
        $is_feature_test_list_mode = $has_feature_name && !$has_test_name;
        $is_run_test_mode = $has_feature_name && $has_test_name;

        // Get writer
        $writer = $this->writer;

        // Get formatter
        $format = $this->formatter;

        // Formatting codes
        $reset = $format->reset;
        $red   = $format->fg_bright_red;
        $gray  = $format->fg_bright_black;
        $teal  = $format->fg_dark_cyan;
        $cyan  = $format->fg_bright_cyan;

        if($is_feature_list_mode){
            // Write message
            $writer->br();
            $writer->writeLine('Pick a Feature to Test:');
            $writer->writeLine("{$gray}──────────────────────────────────────────────────────────────────{$reset}");
            $writer->writeLine(" - {$teal}php pith test-drive {$reset}{$cyan}about{$reset} <---- Test-drive the About object.");
            $writer->writeLine("{$gray}──────────────────────────────────────────────────────────────────{$reset}");
            $writer->br();
        }
        elseif($is_feature_test_list_mode){
            if($feature_name === 'about'){
                $test_driver = new AboutTestDriver();
                $test_list = $test_driver->getTestList();

                $this->displayFeatureTestDriveList($feature_name, $test_list);
            }
            else{
                $writer->writeLine("{$red}Unknown feature.{$reset}");
            }
        }
        elseif ($is_run_test_mode){
            if($feature_name === 'about'){
                $test_driver = new AboutTestDriver();
                $test_driver->runTest($test_name);
            }
            else{
                $writer->writeLine("{$red}Unknown feature.{$reset}");
            }
        }
    }

    /**
     * @param string $feature_name
     * @param string[] $test_list
     * @return void
     *
     * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
     */
    protected function displayFeatureTestDriveList(string $feature_name, array $test_list): void
    {
        // Get writer
        $writer = $this->writer;

        // Get formatter
        $format = $this->formatter;

        // Formatting codes
        $reset = $format->reset;
        $red   = $format->fg_bright_red;
        $gray  = $format->fg_bright_black;
        $teal  = $format->fg_dark_cyan;
        $cyan  = $format->fg_bright_cyan;

        // Write message
        $writer->br();
        $writer->writeLine('Pick a Feature to Test:');
        $writer->writeLine("{$gray}──────────────────────────────────────────────────────────────────{$reset}");

        foreach($test_list as $test){
            $writer->writeLine(" - {$teal}php pith test-drive {$feature_name} {$reset}{$cyan}$test{$reset}");
        }

        $writer->writeLine("{$gray}──────────────────────────────────────────────────────────────────{$reset}");
        $writer->br();
    }
}