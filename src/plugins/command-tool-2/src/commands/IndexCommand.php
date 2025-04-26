<?php

/**
 * Index Command
 * -------------
 *
 * @noinspection PhpMethodNamingConventionInspection   - Short method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\CommandTool2;

/**
 * Class IndexCommand
 */
class IndexCommand
{
    public function __construct()
    {
        // Do nothing for now.
    }

    public function run(): void
    {
        $art_service = new ArtService();
        $writer = new \IKM\CLI\CommandLineWriter();
        $format = new \IKM\CLI\CommandLineFormatter();

        // Draw logo art
        $art_service->drawPithFrameworkLogo();

        $reset = $format->reset;
        $cyan  = $format->fg_bright_cyan;
        $blue  = $format->fg_bright_blue;
        $teal  = $format->fg_dark_cyan;

        $writer->writeLine(" - {$teal}php pith {$reset}{$cyan}app{$reset}     <---- View/update the Pith application here.");
        $writer->writeLine(" - {$teal}php pith {$reset}{$cyan}bar{$reset}     <---- Just a test, command should fail.");
        $writer->writeLine(" - {$teal}php pith {$reset}{$cyan}foo{$reset}     <---- Just a test, command should work.");
        $writer->writeLine(" - {$teal}php pith {$reset}{$cyan}version{$reset} <---- See the current version info.");
        $writer->br();
    }

}