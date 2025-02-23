<?php

/**
 * Shared UI Resource Pack
 * -----------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedUiResourcePack;

use Pith\Workflow\PithPack;

/**
 * Class SharedUiResourcePack
 * @package Pith\Framework\SharedUiResourcePack
 */
class SharedUiResourcePack extends PithPack
{
    public string $access_level = 'world';
    public string $pack_type    = 'resource-pack';
}