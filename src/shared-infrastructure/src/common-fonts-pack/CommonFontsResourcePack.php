<?php

/**
 * Common Fonts Resource Pack
 * --------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\CommonFontsResourcePack;

use Pith\Workflow\PithPack;

/**
 * Class CommonFontsResourcePack
 * @package Pith\Framework\SharedUiResourcePack
 */
class CommonFontsResourcePack extends PithPack
{
    public string $access_level = 'world';
    public string $pack_type    = 'resource-pack';
}