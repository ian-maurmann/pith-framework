<?php

/**
 * Demonstrate Library: OxCSS View-Requisition
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
 * Class DemonstrateLibraryOxCssViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateLibraryOxCssViewRequisition extends PithViewRequisition
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
        $this->addStylesheet('OxCSS stylesheet', '/resources/vendor/common-libraries/oxcss-0.1.4/dist/ox.css', 'library-for-page');
        $this->addScript('jquery', '/resources/vendor/common-libraries/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-page');
        $this->addScript('OxCSS script', '/resources/vendor/common-libraries/oxcss-0.1.4/dist/ox.js', 'library-for-page');
    }
}