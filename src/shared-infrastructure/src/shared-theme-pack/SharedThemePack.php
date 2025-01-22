<?php

/**
 * Shared Theme Pack
 * -----------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedThemePack;

//use Pith\Framework\PithPack;
use Pith\Workflow\PithPack;


/**
 * Class SharedInfrastructurePack
 * @package Pith\Framework\SharedThemePack
 */
class SharedThemePack extends PithPack
{
    public string $access_level = 'world';
}