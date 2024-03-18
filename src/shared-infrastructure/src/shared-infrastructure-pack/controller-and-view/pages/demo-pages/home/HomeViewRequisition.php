<?php

/**
 * Home view-requisition
 * ---------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PRS-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithViewRequisition;

/**
 * Class HomeViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class HomeViewRequisition extends PithViewRequisition
{
    public string $requisition_type = 'view-requisition';

    public function runRequisition()
    {
        // Preload fonts
        $this->addPreload('preload IBM Plex Sans font', '/resources/vendor/library/ibm-plex/plex-2023/ibm-plex-sans/ibm-plex-sans.css', 'font-preload', 'style');

        // CSS Libraries
        $this->addStylesheet('Font Awesome 6 free version', '/resources/vendor/library/font-awesome/font-awesome-free-6.4.0-web/css/all.css', 'library-for-page');
        $this->addStylesheet('Font Awesome 4 compatibility', '/resources/vendor/library/font-awesome/font-awesome-4.7.0-compatibility-fork/css/font-awesome-4-compatibility-fork.min.css', 'library-for-page');
        $this->addStylesheet('Bootstrap Icons stylesheet', '/resources/vendor/library/bootstrap/bootstrap-icons-1.10.5/bootstrap-icons.min.css', 'library-for-page');
        $this->addStylesheet( 'OxCSS stylesheet',  '/resources/vendor/library/oxcss/oxcss-0.1.4/dist/ox.css', 'library-for-page');
        $this->addStylesheet('Swal2 NA stylesheet', '/resources/vendor/library/sweet-alert/swal2-no-anthems-11.7.3/swal2-na.css', 'library-for-page');
        $this->addStylesheet('Re-style Swal2', '/resources/vendor/common-libraries/swal2-custom-themes/swal2-aerogel-theme.css', 'library-for-page');
        $this->addStylesheet('Hoja Aquamarine stylesheet', '/resources/vendor/library/hoja/hoja-aquamarine/hoja-aquamarine.css', 'library-for-page');
        $this->addStylesheet('Aero-Gel stylesheet', '/resources/vendor/library/aero-gel/aero-gel-1.0.0/aero-gel.css', 'library-for-page');

        // JS Libraries
        $this->addScript(     'jQuery', '/resources/vendor/library/jquery/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-page');
        $this->addScript(     'OxCSS script','/resources/vendor/library/oxcss/oxcss-0.1.4/dist/ox.js', 'library-for-page');
        $this->addScript('Swal2 NA script', '/resources/vendor/library/sweet-alert/swal2-no-anthems-11.7.3/swal2-na.all.js', 'library-for-page');

        // App CSS
        // $this->addStylesheet( 'New User Signup stylesheet', '/resources/framework/shared-ui/user-system/new-user-signup.css', 'application-for-page');
        // $this->addStylesheet( 'Login stylesheet', '/resources/framework/shared-ui/user-system/login.css', 'application-for-page');

        // App JS
        // $this->addScript(     'Shared-UI Mask script', '/resources/framework/shared-ui/utilities/input-mask-utility.js', 'application-for-page');
        // $this->addScript(     'New User Signup script', '/resources/framework/shared-ui/user-system/new-user-signup.js', 'application-for-page');
        // $this->addScript(     'Login script', '/resources/framework/shared-ui/user-system/login.js', 'application-for-page');

        //$this->addScript(     'Logout Success Message script', '/resources/framework/shared-ui/user-system/logout-success-landing-pop.js', 'application-for-page');
        //$this->addScript(     'Logout Failure Message script', '/resources/framework/shared-ui/user-system/logout-failure-landing-pop.js', 'application-for-page');

        // Font
        $this->addStylesheet( 'IBM Plex Sans font', '/resources/vendor/library/ibm-plex/plex-2023/ibm-plex-sans/ibm-plex-sans.css', 'font-stylesheet');
    }
}