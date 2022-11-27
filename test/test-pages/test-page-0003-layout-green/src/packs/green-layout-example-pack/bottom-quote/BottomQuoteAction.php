<?php

/**
 * Bottom Quote Action
 * -------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok here.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithAction;

/**
 * Class BottomQuoteAction
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample
 */
class BottomQuoteAction extends PithAction
{
    public function runAction()
    {
        // Variables
        $version_text = $this->app->info->getVersionSlug();

        // ------------------------------------------------
        // This normally shouldn't be inside the action

        $sql = 'SELECT * FROM dev_quotes WHERE quote_id = 1';

        $results = $this->app->db->query($sql);
        $has_results = count($results) > 0;

        $quote = 'No quote found';
        if($has_results){
            $quote = $results[0]['quote'];
        }

        //-------------------------------------------------



        // Push to Preparer
        $this->prepare->version_text = $version_text;
        $this->prepare->quote        = $quote;
    }
}