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

        // Resources:

        // Animate.css Stylesheet
        // $this->addStylesheet('Animate.css Stylesheet', '/resources/vendor/common-libraries/animate.css/animate.css-4.1.1/animate.min.css', 'library-for-page');
        $this->addCdnStylesheet('Animate.css Stylesheet', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', 'sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==', 'anonymous', '/resources/vendor/common-libraries/animate.css/animate.css-4.1.1/animate.min.css', 'library-for-page');

        // jQuery Script
        //$this->addScript('jquery', '/resources/vendor/common-libraries/jquery/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-page');
        $this->addCdnScript('jQuery', 'https://code.jquery.com/jquery-3.7.1.min.js', 'sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=', 'anonymous', '/resources/vendor/common-libraries/jquery/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-page');
    }
}