<?php

/**
 * Pith User System 3 pack
 * ----------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\UserSystem3;

use Pith\Workflow\PithPack;

/**
 * Class PithUserSystem3Pack
 */
class PithUserSystem3Pack extends PithPack
{
    public string $access_level = 'world';
} 