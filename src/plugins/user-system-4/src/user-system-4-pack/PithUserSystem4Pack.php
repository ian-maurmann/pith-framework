<?php

/**
 * Pith User System 4 pack
 * ----------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\UserSystem4;

use Pith\Workflow\PithPack;

/**
 * Class PithUserSystem4Pack
 */
class PithUserSystem4Pack extends PithPack
{
    public string $access_level = 'world';
} 