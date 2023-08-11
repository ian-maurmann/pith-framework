<?php

/**
 * Home Action
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Action parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel\Pages;

use Pith\Framework\PithAction;

/**
 * Class HomeAction
 * @package Pith\Framework\Panel\Pages
 */
class HomeAction extends PithAction
{
    public function runAction()
    {
        // Push to Preparer
        $this->prepare->PITH_PANEL_PATH = PITH_PANEL_PATH;
    }
}