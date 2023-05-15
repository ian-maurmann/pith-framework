<?php

/**
 * Common Libraries Resource Pack
 * ------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\CommonLibrariesResourcePack;

use Pith\Framework\PithPack;

/**
 * Class CommonLibrariesResourcePack
 * @package Pith\Framework\SharedUiResourcePack
 */
class CommonLibrariesResourcePack extends PithPack
{
    public string $access_level = 'world';
    public string $pack_type    = 'resource-pack';
}