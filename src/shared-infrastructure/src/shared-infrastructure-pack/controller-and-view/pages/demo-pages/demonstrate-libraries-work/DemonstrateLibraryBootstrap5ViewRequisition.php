<?php

/**
 * Demonstrate Library: Bootstrap5 View-Requisition
 * ------------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithViewRequisition;

/**
 * Class DemonstrateLibraryBootstrap5ViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryBootstrap5ViewRequisition extends PithViewRequisition
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

        //<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        // Resources
        $this->addStylesheet('Bootstrap 5 stylesheet', '/resources/vendor/library/bootstrap/bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css', 'library-for-page');
        $this->addStylesheet('Bootstrap Icons stylesheet', '/resources/vendor/library/bootstrap/bootstrap-icons-1.10.5/bootstrap-icons.min.css', 'library-for-page');
        $this->addScript('Bootstrap 5 Bundle script', '/resources/vendor/library/bootstrap/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js', 'library-for-page');
    }
}