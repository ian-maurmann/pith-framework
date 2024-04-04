<?php

/**
 * Test Email view-requisition
 * ---------------------------
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
 * Class TestEmailViewRequisition
 * @package Pith\Framework\SharedInfrastructure
 */
class TestEmailViewRequisition extends PithViewRequisition
{
    public string $requisition_type = 'view-requisition';

    public function runRequisition()
    {
        // JS Libraries
        $this->addScript(     'jQuery', '/resources/vendor/library/jquery/jquery-3.6.4/jquery-3.6.4.min.js', 'library-for-page');

        // App JS
        $this->addScript(     'Login script', '/resources/framework/shared-ui/email/test-email.js', 'application-for-page');

    }
}