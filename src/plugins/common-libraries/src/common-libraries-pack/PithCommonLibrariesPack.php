<?php

/**
 * Pith Common Libraries pack
 * --------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\CommonLibraries;

use Pith\Workflow\PithPack;

/**
 * Class PithCommonLibrariesPack
 */
class PithCommonLibrariesPack extends PithPack
{
    public string $access_level = 'world';
} 