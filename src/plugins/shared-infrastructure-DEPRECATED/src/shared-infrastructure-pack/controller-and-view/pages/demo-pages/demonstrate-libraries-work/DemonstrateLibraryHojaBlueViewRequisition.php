<?php

/**
 * Demonstrate Library: Hoja Blue View-Requisition
 * -----------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithViewRequisition;

/**
 * Class DemonstrateLibraryHojaBlueViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryHojaBlueViewRequisition extends PithViewRequisition
{
    public string $requisition_type = 'view-requisition';

    public function runRequisition()
    {
        // Resource roles:
        //     0 - reset
        //     1 - library-for-layout
        //     2 - library-for-page
        //     3 - library-for-partial
        //     4 - application-for-layout
        //     5 - application-for-page
        //     6 - application-for-partial

        // Resources
        $this->addStylesheet('Hoja Blue stylesheet', '/resources/vendor/common-libraries/hoja/hoja-blue/hoja-blue.css', 'library-for-page');
    }
}