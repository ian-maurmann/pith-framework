<?php

/**
 * Env Info Layout View Requisition
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
class EnvInfoLayoutViewRequisition extends PithViewRequisition
{
    public string $requisition_type = 'layout-view-requisition';

    public function runRequisition()
    {
        // Headers
        $this->addHeader('Use UTF-8 Encoding', 'Content-Type: text/html; charset=utf-8');

        // Resource roles:
        //     0 - reset
        //     1 - library-for-layout
        //     2 - library-for-page
        //     3 - library-for-partial
        //     4 - application-for-layout
        //     5 - application-for-page
        //     6 - application-for-partial

        // Resources
        $this->addStylesheet('JetBrains Mono NL font', '/resources/vendor/common-fonts/fontsheets/jetbrains-mono-nl.css', 'library-for-layout');
        $this->addStylesheet('Fixie Reset 4 Stylesheet', '/resources/vendor/common-libraries/fixie-reset-4.0.2/fixie-reset.css', 'reset');
        $this->addStylesheet('OxCSS stylesheet', '/resources/vendor/common-libraries/oxcss-0.1.4/dist/ox.css', 'library-for-layout');
        $this->addScript('jquery', '/resources/vendor/common-libraries/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-layout');
        $this->addScript('OxCSS script', '/resources/vendor/common-libraries/oxcss-0.1.4/dist/ox.js', 'library-for-layout');
        $this->addStylesheet('Font Awesome 6 free version', '/resources/vendor/common-libraries/font-awesome-free-6.4.0-web/css/all.css', 'library-for-layout');
        $this->addStylesheet('Font Awesome 4 compatibility', '/resources/vendor/common-libraries/font-awesome-4.7.0-compatibility-fork/css/font-awesome-4-compatibility-fork.min.css', 'library-for-layout');
        $this->addStylesheet('Env Info Stylesheet', '/resources/framework/shared-ui/env-info-theme/env-info-theme.css', 'application-for-layout');
    }
}