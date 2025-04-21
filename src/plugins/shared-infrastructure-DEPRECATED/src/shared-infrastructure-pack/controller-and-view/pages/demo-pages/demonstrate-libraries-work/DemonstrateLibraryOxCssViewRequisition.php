<?php

/**
 * Demonstrate Library: OxCSS View-Requisition
 * -------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithViewRequisition;

/**
 * Class DemonstrateLibraryOxCssViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryOxCssViewRequisition extends PithViewRequisition
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
        $this->addStylesheet('OxCSS stylesheet', '/resources/vendor/common-libraries/oxcss/oxcss-0.1.4/dist/ox.css', 'library-for-page');
        $this->addScript('jquery', '/resources/vendor/common-libraries/jquery/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-page');
        $this->addScript('OxCSS script', '/resources/vendor/common-libraries/oxcss/oxcss-0.1.4/dist/ox.js', 'library-for-page');
    }
}