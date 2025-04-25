<?php

/**
 * Demonstrate Library: Swal2NA View-Requisition
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
 * Class DemonstrateLibrarySwal2NaViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibrarySwal2NaViewRequisition extends PithViewRequisition
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
        $this->addStylesheet('Swal2 NA stylesheet', '/resources/vendor/common-libraries/sweetalert/swal2-no-anthems-11.7.3/swal2-na.css', 'library-for-page');
        $this->addScript('Swal2 NA script', '/resources/vendor/common-libraries/sweetalert/swal2-no-anthems-11.7.3/swal2-na.all.js', 'library-for-page');
    }
}