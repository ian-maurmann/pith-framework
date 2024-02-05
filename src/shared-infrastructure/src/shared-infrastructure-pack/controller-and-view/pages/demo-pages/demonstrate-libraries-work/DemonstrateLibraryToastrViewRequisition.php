<?php

/**
 * Demonstrate Library: Toastr View-Requisition
 * --------------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithViewRequisition;

/**
 * Class DemonstrateLibraryToastrViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryToastrViewRequisition extends PithViewRequisition
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
        $this->addStylesheet('Toastr - CSS', '/resources/vendor/common-libraries/toastr-2.1.4/build/toastr.css', 'library-for-page');
        $this->addScript('jquery', '/resources/vendor/common-libraries/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-page');
        $this->addScript('Toastr - JavaScript', '/resources/vendor/common-libraries/toastr-2.1.4/build/toastr.min.js', 'library-for-page');
    }
}