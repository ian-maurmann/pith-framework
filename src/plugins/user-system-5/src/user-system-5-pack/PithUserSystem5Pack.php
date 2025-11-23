<?php

/**
 * Pith User System 5 pack
 * ----------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\UserSystem5;

use Pith\Workflow\PithPack;

/**
 * Class PithUserSystem5Pack
 */
class PithUserSystem5Pack extends PithPack
{
    public string $access_level = 'world';
} 