<?php

/**
 * Example Resource Pack
 * --------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageOne\YellowJelloResourcePack;

use Pith\Framework\PithPack;

/**
 * Class ExampleResourcePack
 * @package Pith\Framework\Test\TestPage\TestPageOne\YellowJelloResourcePack
 */
class YellowJelloResourcePack extends PithPack
{
    public string $access_level = 'world';
    public string $pack_type    = 'resource-pack';
}