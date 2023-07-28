<?php

/**
 * Lorem Ipsum task action
 * -----------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4, not PSR-0.
 */

declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks;

use Pith\Framework\PithAction;
use Pith\Framework\PithAppRetriever;
use Pith\Framework\SharedInfrastructure\Model\UserSystem\UserService;

/**
 * Class LoremIpsumTaskAction
 * @package Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks
 */
class LoremIpsumTaskAction extends PithAction
{
    private PithAppRetriever $app_retriever;

    public function __construct(PithAppRetriever $app_retriever)
    {
        // Set object dependencies
        $this->app_retriever = $app_retriever;
    }

    public function runAction()
    {
        // Get app
        $app = $this->app_retriever->getApp();
        $format = $app->cli_format;

        // Test the CLI Writer ---- CLI View Adapter show also remember this in the view

        $app->cli_writer->writeLine($format->fg_bright_yellow . '┌───────────────┐' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '│  lorem_ipsum  │' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '└───────────────┘' . $format->reset);

        $app->cli_writer->writeLine('    ');

        $app->cli_writer->writeLine('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean malesuada viverra arcu. Vestibulum condimentum fermentum tortor nec sagittis. Suspendisse mi purus, sagittis et sem in, efficitur blandit nisi. Donec tempus venenatis risus at gravida. Vivamus accumsan ante et felis ullamcorper luctus in quis ex. Nulla varius mauris lacus, eu pharetra metus elementum et. Ut quis dictum felis. Ut nec maximus justo. Aenean mollis erat libero, molestie bibendum ipsum dignissim faucibus. Etiam a cursus ex. Nunc dignissim ultricies ante, at pellentesque sapien varius non. Praesent tincidunt, enim ultricies condimentum aliquet, odio nulla malesuada orci, id laoreet eros dui vel mi. Morbi vitae ipsum ut est vehicula rhoncus.');

        $app->cli_writer->writeLine('    ');

        $app->cli_writer->writeLine($format->fg_dark_black . 'dark black'  . $format->reset);
        $app->cli_writer->writeLine($format->fg_dark_red . 'dark red'  . $format->reset);
        $app->cli_writer->writeLine($format->fg_dark_green . 'dark green'  . $format->reset);
    }

}