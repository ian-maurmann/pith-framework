<?php

/**
 * Jello Partial View Requisition
 * ------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpMissingParentCallCommonInspection  - Preparer parent methods exist as fallback.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack;

use Pith\Framework\PithViewRequisition;

/**
 * Class JelloPartialViewRequisition
 * @package Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack
 */
class JelloPartialViewRequisition extends PithViewRequisition
{
    public string $requisition_type = 'partial-view-requisition';

    public function runRequisition()
    {
        // Headers
        $this->addHeader('Use UTF-8 Encoding', 'Content-Type: text/html; charset=utf-8');
        $this->addHeader('Show site runs PHP 8', 'X-Powered-By: PHP/8');

        // Resources
        $this->addScript('Foo Library', '/library/foo/foo.js', 'library-for-layout');
    }
}