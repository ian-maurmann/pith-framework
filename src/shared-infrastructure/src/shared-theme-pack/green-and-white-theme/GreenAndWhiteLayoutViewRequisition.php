<?php

/**
 * Green & White Layout View Requisition
 * -------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedThemePack;

use Pith\Framework\PithViewRequisition;

/**
 * Class GreenAndWhiteLayoutViewRequisition
 * @package Pith\Framework\SharedThemePack
 */
class GreenAndWhiteLayoutViewRequisition extends PithViewRequisition
{
    public string $requisition_type = 'layout-view-requisition';

    public function runRequisition()
    {
        // Headers
        $this->addHeader('Use UTF-8 Encoding', 'Content-Type: text/html; charset=utf-8');
        $this->addHeader('Show site runs PHP 8', 'X-Powered-By: PHP/8');

        // Resource roles:
        //     0 - reset
        //     1 - library-for-layout
        //     2 - library-for-page
        //     3 - library-for-partial
        //     4 - application-for-layout
        //     5 - application-for-page
        //     6 - application-for-partial

        // Resources
        $this->addStylesheet('Fixie Reset 4 Stylesheet', '/resources/vendor/common-libraries/fixie-reset-4.0.2/fixie-reset.css', 'reset');
        $this->addStylesheet('Green Layout Stylesheet', '/resources/framework/shared-ui/green-and-white-theme/green-and-white-theme.css', 'application-for-layout');
    }
}