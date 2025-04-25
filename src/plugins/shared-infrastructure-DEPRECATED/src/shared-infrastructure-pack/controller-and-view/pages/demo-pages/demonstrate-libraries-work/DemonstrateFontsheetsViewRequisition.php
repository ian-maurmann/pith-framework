<?php

/**
 * Demonstrate Fontsheets View-Requisition
 * ---------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithViewRequisition;

/**
 * Class DemonstrateFontsheetsViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class DemonstrateFontsheetsViewRequisition extends PithViewRequisition
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
        $this->addPreload('preload JetBrains Mono NL font', '/resources/vendor/common-libraries/jetbrains-mono-nl/jetbrains-mono-2.304/jetbrains-mono-nl.css', 'font-preload', 'style');
        $this->addPreload('preload IBM Plex Sans font', '/resources/vendor/common-libraries/ibm-plex/plex-2023/ibm-plex-sans/ibm-plex-sans.css', 'font-preload', 'style');
        $this->addStylesheet( 'JetBrains Mono NL font', '/resources/vendor/common-libraries/jetbrains-mono-nl/jetbrains-mono-2.304/jetbrains-mono-nl.css', 'font-stylesheet');
        $this->addStylesheet( 'IBM Plex Sans font', '/resources/vendor/common-libraries/ibm-plex/plex-2023/ibm-plex-sans/ibm-plex-sans.css', 'font-stylesheet');
    }
}