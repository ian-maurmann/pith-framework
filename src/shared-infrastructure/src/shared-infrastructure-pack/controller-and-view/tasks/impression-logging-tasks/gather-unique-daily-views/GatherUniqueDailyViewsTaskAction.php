<?php

/**
 * Gather Unique Daily Views Task Action
 * -------------------------------------
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
use Pith\Framework\PithException;
use Pith\Framework\SharedInfrastructure\Model\ImpressionSystem\ImpressionService;

/**
 * Class GatherUniqueDailyViewsTaskAction
 * @package Pith\Framework\SharedInfrastructure\Tasks\ImpressionLoggingTasks
 */
class GatherUniqueDailyViewsTaskAction extends PithAction
{
    private PithAppRetriever  $app_retriever;
    private ImpressionService $impression_service;

    public function __construct(PithAppRetriever $app_retriever, ImpressionService $impression_service)
    {
        // Set object dependencies
        $this->app_retriever      = $app_retriever;
        $this->impression_service = $impression_service;
    }

    /**
     * @throws PithException
     */
    public function runAction()
    {
        $continue = true;

        // Get app
        $app = $this->app_retriever->getApp();

        // Get CLI format
        $format = $app->cli_format;

        // Header
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┏━─────────────────────────────────────────────────────────━┓' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┃  Impression Logging - Task 5 - Gather Unique Daily Views  ┃' . $format->reset);
        $app->cli_writer->writeLine($format->fg_bright_yellow . '┗━─────────────────────────────────────────────────────────━┛' . $format->reset);
        $app->cli_writer->writeLine(' ');

        // "Find distinct impressions without unique daily view"
        if($continue){
            $app->cli_writer->writeLine($format->fg_dark_yellow . 'Find distinct impressions without unique daily view.' . $format->reset);
            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Selecting distinct...');

            $new_distinct_impressions = $this->impression_service->findDistinctImpressionsWithoutUniqueDailyViews();
            $number_of_new_distinct_impressions_found = count($new_distinct_impressions);
            $has_new_distinct_impressions = $number_of_new_distinct_impressions_found > 0;

            $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'New distinct impressions found: ' . $format->fg_dark_cyan . $number_of_new_distinct_impressions_found . $format->reset);

            if(!$has_new_distinct_impressions){
                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Stopping.');
                $continue = false;
            }
        }

        if($continue){
            $app->cli_writer->writeLine($format->fg_dark_yellow . 'Add unique daily views.' . $format->reset);

            foreach($new_distinct_impressions as $distinct_impression_index => $distinct_impression){
                $at_number = $distinct_impression_index + 1;

                $app->cli_writer->writeLine('  ' . $format->fg_dark_yellow . '- ' . $format->reset . $at_number);

                $app->cli_writer->writeLine('      ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Inserting...');

                // Try to insert
                $inserted_id = 0;
                try {
                    $inserted_id = $this->impression_service->insertNewUniqueDailyView($distinct_impression);
                } catch (PithException $e) {
                    // Do nothing for now
                }

                $did_insert = $inserted_id > 0;
                if($did_insert){
                    $app->cli_writer->writeLine('      ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Did insert?: ' . $format->fg_bright_green . 'yes' . $format->reset);
                    $app->cli_writer->writeLine('      ' . $format->fg_dark_yellow . '- ' . $format->reset . 'New inserted id: ' . $format->fg_bright_green . $inserted_id . $format->reset);
                }
                else{
                    $app->cli_writer->writeLine('      ' . $format->fg_dark_yellow . '- ' . $format->reset . 'Did insert?: ' . $format->fg_bright_red . 'no' . $format->reset);
                }


            }

        }
    }

}