<?php

/**
 * Demonstrate Loading From CDN view-requisition
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
 * Class DemonstrateLoadingFromCdnViewRequisition
 */
class DemonstrateLoadingFromCdnViewRequisition extends PithViewRequisition
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


        //$this->addScript('jquery', '/resources/vendor/common-libraries/jquery/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-page');

        $this->addCdnScript('jQuery', 'https://code.jquery.com/jquery-3.7.1.min.js', 'sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=', 'anonymous', '/resources/vendor/common-libraries/jquery/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-page');

        $this->addScript('OxCSS script', '/resources/vendor/common-libraries/oxcss/oxcss-0.1.4/dist/ox.js', 'library-for-page');
    }
}