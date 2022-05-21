<?php

/**
 * Jello Layout View Requisition
 * -----------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

use Pith\Framework\PithViewRequisition;

/**
 * Class JelloLayoutViewRequisition
 * @package Pith\ExampleAirshipPack
 */
class JelloLayoutViewRequisition extends PithViewRequisition
{
    public $requisition_type = 'view-requisition';

    public function runRequisition()
    {
        // Headers
        $this->addHeader('Use UTF-8 Encoding', 'Content-Type: text/html; charset=utf-8');

        // Resources
        $this->addScript('Foo Library', '/library/foo/foo.js', 'library');
    }
}