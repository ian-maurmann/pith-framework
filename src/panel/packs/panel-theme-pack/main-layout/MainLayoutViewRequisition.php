<?php

/**
 * Main Layout View-Requisition
 * ----------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel\Theme;

use Pith\Workflow\PithViewRequisition;

/**
 * Class MainLayoutViewRequisition
 *
 * - Adds resources for the Pith Panel theme
 *
 * @package Pith\Framework\Panel\Theme
 */
class MainLayoutViewRequisition extends PithViewRequisition
{
    public string $requisition_type = 'layout-view-requisition';

    public function runRequisition()
    {
        // Headers
        $this->addHeader('Use UTF-8 Encoding', 'Content-Type: text/html; charset=utf-8');

        // Preload fonts for layout
        $this->addPreload('preload IBM Plex Sans font', '/resources/vendor/library/ibm-plex/plex-2023/ibm-plex-sans/ibm-plex-sans.css', 'font-preload', 'style');
        $this->addPreload('preload JetBrains Mono NL font',  '/resources/vendor/library/jetbrains-mono-nl/jetbrains-mono-2.304/jetbrains-mono-nl.css', 'font-preload', 'style');

        // CSS Resets for layout
        $this->addStylesheet('Fixie Reset 4 Stylesheet', '/resources/vendor/library/fixie-reset/fixie-reset-4.1.0/fixie-reset.css', 'reset');

        // CSS Libraries for layout
        $this->addStylesheet('Font Awesome 6 free version', '/resources/vendor/library/font-awesome/font-awesome-free-6.4.0-web/css/all.css', 'library-for-layout');
        $this->addStylesheet('Font Awesome 4 compatibility', '/resources/vendor/library/font-awesome/font-awesome-4.7.0-compatibility-fork/css/font-awesome-4-compatibility-fork.min.css', 'library-for-layout');
        $this->addStylesheet('Bootstrap Icons stylesheet', '/resources/vendor/library/bootstrap/bootstrap-icons-1.10.5/bootstrap-icons.min.css', 'library-for-layout');
        $this->addStylesheet('OxCSS stylesheet',  '/resources/vendor/common-libraries/oxcss-0.1.4/dist/ox.css', 'library-for-layout');
        $this->addStylesheet('Swal2 NA stylesheet', '/resources/vendor/common-libraries/swal2-no-anthems-11.7.3/swal2-na.css', 'library-for-layout');
        $this->addStylesheet('Re-style Swal2', '/resources/vendor/common-libraries/swal2-custom-themes/swal2-aerogel-theme.css', 'library-for-layout');
        $this->addStylesheet('Hoja Aquamarine stylesheet', '/resources/vendor/library/hoja/hoja-aquamarine/hoja-aquamarine.css', 'library-for-layout');
        $this->addStylesheet('Aero-Gel stylesheet', '/resources/vendor/library/aero-gel/aero-gel-1.0.0/aero-gel.css', 'library-for-layout');

        // JS Libraries for layout
        $this->addScript('jQuery', '/resources/vendor/library/jquery/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-layout');
        $this->addScript('OxCSS script','/resources/vendor/common-libraries/oxcss-0.1.4/dist/ox.js', 'library-for-layout');
        $this->addScript('Swal2 NA script', '/resources/vendor/common-libraries/swal2-no-anthems-11.7.3/swal2-na.all.js', 'library-for-layout');

        // App CSS for layout
        $this->addStylesheet('Panel Stylesheet', PITH_PANEL_PATH . '/resources/panel-theme.css', 'application-for-layout');

        // App JS for layout
        $this->addScript('Panel Top-Menu script', PITH_PANEL_PATH . '/resources/panel-top-menu.js', 'application-for-layout');

        // Font
        $this->addStylesheet( 'IBM Plex Sans font', '/resources/vendor/library/ibm-plex/plex-2023/ibm-plex-sans/ibm-plex-sans.css', 'font-stylesheet');
        $this->addStylesheet( 'JetBrains Mono NL font', '/resources/vendor/library/jetbrains-mono-nl/jetbrains-mono-2.304/jetbrains-mono-nl.css', 'font-stylesheet');
    }
}