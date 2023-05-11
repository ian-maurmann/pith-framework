<?php

/**
 * Demonstrate Library: FontAwesome4 View-Requisition
 * --------------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithViewRequisition;

/**
 * Class DemonstrateLibraryFontAwesome4ViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryFontAwesome4ViewRequisition extends PithViewRequisition
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
        $this->addStylesheet('Font Awesome', '/resources/vendor/common-libraries/font-awesome-4.7.0/css/font-awesome.min.css', 'library-for-page');
    }
}