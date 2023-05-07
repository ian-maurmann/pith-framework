<?php

/**
 * Shared Infrastructure Pack
 * --------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithPack;

/**
 * Class SharedInfrastructurePack
 * @package Pith\Framework\SharedInfrastructure
 */
class SharedInfrastructurePack extends PithPack
{
    public string $access_level = 'world';
}