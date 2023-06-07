<?php

/**
 * New User view-requisition
 * -------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithViewRequisition;

/**
 * Class NewUserViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class NewUserViewRequisition extends PithViewRequisition
{
    public string $requisition_type = 'view-requisition';

    public function runRequisition()
    {
        // Resources
        $this->addStylesheet('Font Awesome 6 free version', '/resources/vendor/common-libraries/font-awesome-free-6.4.0-web/css/all.css', 'library-for-page');
        $this->addStylesheet('Font Awesome 4 compatibility', '/resources/vendor/common-libraries/font-awesome-4.7.0-compatibility-fork/css/font-awesome-4-compatibility-fork.min.css', 'library-for-page');

        $this->addStylesheet('Bootstrap Icons stylesheet', '/resources/vendor/common-libraries/bootstrap-icons-font-1.10.5/font/bootstrap-icons.min.css', 'library-for-page');

        $this->addStylesheet( 'OxCSS stylesheet',  '/resources/vendor/common-libraries/oxcss-0.1.4/dist/ox.css', 'library-for-page');
        $this->addScript(     'jQuery', '/resources/vendor/common-libraries/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-page');
        $this->addScript(     'OxCSS script','/resources/vendor/common-libraries/oxcss-0.1.4/dist/ox.js', 'library-for-page');


        $this->addStylesheet( 'New User Signup stylesheet', '/resources/framework/shared-ui/user-system/new-user-signup.css', 'application-for-page');
        $this->addScript(     'New User Signup script', '/resources/framework/shared-ui/user-system/new-user-signup.js', 'application-for-page');
    }
}