<?php

/**
 * Pith Panel Theme Pack
 * ---------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel\Theme;

use Pith\Workflow\PithPack;

/**
 * Class PithPanelThemePack
 * @package Pith\Framework\Panel\Theme
 */
class PithPanelThemePack extends PithPack
{
    public string $access_level = 'world';
}