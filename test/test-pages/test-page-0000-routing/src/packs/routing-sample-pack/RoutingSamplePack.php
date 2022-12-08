<?php

/**
 * Routing Sample Pack
 * -------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageZero\RoutingSamplePack;

use Pith\Framework\PithPack;

/**
 * Class RoutingSamplePack
 * @package Pith\Framework\Test\TestPage\TestPageZero\RoutingSamplePack
 */
class RoutingSamplePack extends PithPack
{
    public string $access_level = 'world';
}