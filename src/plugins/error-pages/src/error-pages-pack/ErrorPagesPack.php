<?php

/**
 * Error Pages Pack
 * ----------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\ErrorPages;

use Pith\Workflow\PithPack;

/**
 * Class ErrorPagesPack
 */
class ErrorPagesPack extends PithPack
{
    public string $access_level = 'world';
}