<?php

/**
 * Hello Preparer
 * --------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithPreparer;

/**
 * Class HelloPreparer
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample
 */
class HelloPreparer extends PithPreparer
{
    public function __construct()
    {
        // Do nothing for now.
    }

    public function runPreparer()
    {
        echo 'Hello Preparer!!!';

        $a = $this->prepare->a;
        $b = $this->prepare->b;
        $c = $this->prepare->c;

        // Debug
        echo $a;
        echo $b;
        echo $c;

        $this->view->a = $a;
        $this->view->b = $b;
        $this->view->c = $c;
    }
}