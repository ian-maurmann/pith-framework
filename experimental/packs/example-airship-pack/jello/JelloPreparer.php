<?php

/**
 * Jello Preparer
 * --------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

use Pith\Framework\PithPreparer;

/**
 * Class JelloPreparer
 * @package Pith\ExampleAirshipPack
 */
class JelloPreparer extends PithPreparer
{
    public function __construct()
    {
        // Do nothing for now.
    }

    public function runPreparer()
    {
        $a = $this->prepare->a;
        $b = $this->prepare->b;
        $c = $this->prepare->c;

        // Debug
        // echo $a;
        // echo $b;
        // echo $c;

        $this->view->a = $a;
        $this->view->b = $b;
        $this->view->c = $c;
    }
}