<?php

/**
 * Demonstrate Library: Jscrollpane View-Requisition
 * -------------------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithViewRequisition;

/**
 * Class DemonstrateLibraryJscrollpaneViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryJscrollpaneViewRequisition extends PithViewRequisition
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
        $this->addStylesheet('jScrollPane stylesheet', '/resources/vendor/common-libraries/jscrollpane-2.2.3-rc.2/style/jquery.jscrollpane.css', 'library-for-page');
        $this->addScript('jQuery', '/resources/vendor/library/jquery/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-page');
        $this->addScript('jQuery Mousewheel plugin', '/resources/vendor/common-libraries/jscrollpane-2.2.3-rc.2/script/jquery.mousewheel.js', 'library-for-page');
        $this->addScript('jScrollPane script', '/resources/vendor/common-libraries/jscrollpane-2.2.3-rc.2/script/jquery.jscrollpane.js', 'library-for-page');
    }
}