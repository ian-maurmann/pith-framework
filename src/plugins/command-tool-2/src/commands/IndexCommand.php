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

use Pith\Framework\PithAppRetriever;

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
        $app_retriever = new PithAppRetriever();
        $app = $app_retriever->getApp();

        $art_service = new ArtService();
        $writer = new \IKM\CLI\CommandLineWriter();
        $format = new \IKM\CLI\CommandLineFormatter();

        // Draw logo art
        $art_service->drawPithFrameworkLogo();

        $version_text = $app->info->getVersionText();
        $copyright_notice = $app->info->getCopyrightNotice();

        $writer->writeLine($version_text);
        $writer->writeLine($copyright_notice);

        $reset = $format->reset;
        $cyan  = $format->fg_bright_cyan;
        $blue  = $format->fg_bright_blue;
        $teal  = $format->fg_dark_cyan;
        $dijon = $format->fg_dark_yellow;
        $gray  = $format->fg_bright_black;

        $writer->writeLine("{$gray}──────────────────────────────────────────────────────────────────{$reset}");
        $writer->writeLine(" - {$teal}php pith {$reset}{$cyan}-v{$reset}         <---- See the current version info.");
        $writer->writeLine(" - {$teal}php pith {$reset}{$cyan}--version{$reset}  <---- See the current version info.");
        $writer->writeLine(" - {$teal}php pith {$reset}{$cyan}--Version{$reset}  <---- See the current version info.");
        $writer->writeLine(" - {$teal}php pith {$reset}{$cyan}app{$reset}        <---- View/update the Pith application here.");
        $writer->writeLine(" - {$teal}php pith {$reset}{$cyan}bar{$reset}        <---- Just a test, command should fail.");
        $writer->writeLine(" - {$teal}php pith {$reset}{$cyan}foo{$reset}        <---- Just a test, command should work.");
        $writer->writeLine(" - {$teal}php pith {$reset}{$cyan}test-drive{$reset} <---- Just a test, command should work.");
        $writer->writeLine(" - {$teal}php pith {$reset}{$cyan}version{$reset}    <---- See the current version info.");
        $writer->writeLine("{$gray}──────────────────────────────────────────────────────────────────{$reset}");
        $writer->br();
    }

}