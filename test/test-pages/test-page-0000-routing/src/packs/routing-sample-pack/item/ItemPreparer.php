<?php

/**
 * Item Preparer
 * --------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageZero\RoutingSamplePack;

use Pith\Framework\PithPreparer;

/**
 * Class ItemPreparer
 * @package Pith\Framework\Test\TestPage\TestPageZero\RoutingSamplePack
 */
class ItemPreparer extends PithPreparer
{
    public function __construct()
    {
        // Do nothing for now.
    }

    public function runPreparer()
    {
        $item_id = $this->prepare->item_id;

        $this->view->item_id = htmlspecialchars( (string) $item_id );
    }
}