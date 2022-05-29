<?php

/**
 * Jello Action
 * ------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

use Pith\Framework\PithAction;

/**
 * Class JelloAction
 * @package Pith\ExampleAirshipPack
 */
class JelloAction extends PithAction
{
    public function __construct()
    {
        // Do nothing for now.
    }

    public function runAction()
    {
        // Variables
        $a = 'Aaa';
        $b = 'Bbb';
        $c = 'Ccc';


        // Debug
        // echo $a;
        // echo $b;
        // echo $c;


        // Push to Preparer
        $this->prepare->a = $a;
        $this->prepare->b = $b;
        $this->prepare->c = $c;
    }
}