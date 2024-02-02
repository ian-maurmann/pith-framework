<?php

/**
 * Demonstrate Fonts Work View-Requisition
 * ---------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithViewRequisition;

/**
 * Class DemonstrateFontsWorkViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateFontsWorkViewRequisition extends PithViewRequisition
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
        $this->addPreload('preload JetBrains Mono NL font', '/resources/vendor/common-fonts/fontsheets/jetbrains-mono-nl.css', 'font-preload', 'style');
        $this->addPreload('preload IBM Plex Sans font', '/resources/vendor/common-fonts/fontsheets/ibm-plex-sans.css', 'font-preload', 'style');

        $this->addStylesheet('Demonstrate Common Fonts Stylesheet', '/resources/framework/shared-ui/demonstration/demonstrate-that-included-common-fonts-work.css', 'font-stylesheet');
        $this->addStylesheet('open-sans-v34 Font Set', '/resources/vendor/common-fonts/vendor-fonts/open-sans-woff2-v34/open-sans.css', 'font-stylesheet');
        $this->addStylesheet( 'JetBrains Mono NL font', '/resources/vendor/common-fonts/fontsheets/jetbrains-mono-nl.css', 'font-stylesheet');
        $this->addStylesheet( 'IBM Plex Sans font', '/resources/vendor/common-fonts/fontsheets/ibm-plex-sans.css', 'font-stylesheet');
    }
}