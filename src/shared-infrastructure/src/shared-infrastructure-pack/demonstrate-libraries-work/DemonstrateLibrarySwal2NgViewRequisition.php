<?php

/**
 * Demonstrate Library: Swal 2 NG View-Requisition
 * -----------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithViewRequisition;

/**
 * Class DemonstrateLibrarySwal2NgViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibrarySwal2NgViewRequisition extends PithViewRequisition
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
        $this->addStylesheet('Swal2 NG stylesheet', '/resources/vendor/common-libraries/swal2-11.7.3-ng-fork/swal2-ng.css', 'library-for-page');
        $this->addScript('Swal2 NG script', '/resources/vendor/common-libraries/swal2-11.7.3-ng-fork/swal2-ng.all.js', 'library-for-page');
    }
}