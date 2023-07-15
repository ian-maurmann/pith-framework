<?php

/**
 * Pith Panel Pages Pack
 * ---------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel\Pages;

use Pith\Framework\PithPack;

/**
 * Class PithPanelPagesPack
 * @package Pith\Framework\Panel\Pages
 */
class PithPanelPagesPack extends PithPack
{
    public string $access_level = 'world';
}