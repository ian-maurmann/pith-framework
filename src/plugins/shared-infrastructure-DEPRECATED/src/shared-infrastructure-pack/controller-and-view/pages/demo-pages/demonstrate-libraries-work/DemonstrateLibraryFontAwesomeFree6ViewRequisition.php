<?php

/**
 * Demonstrate Library: FontAwesome6 View-Requisition
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
 * Class DemonstrateLibraryFontAwesomeFree6ViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryFontAwesomeFree6ViewRequisition extends PithViewRequisition
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
        $this->addStylesheet('Font Awesome', '/resources/vendor/common-libraries/font-awesome/font-awesome-free-6.4.0-web/css/all.css', 'library-for-page');
    }
}