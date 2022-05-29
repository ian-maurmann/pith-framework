<?php

/**
 * Example Resource Pack
 * --------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\ExampleResourcePack;

use Pith\Framework\PithPack;

/**
 * Class ExampleResourcePack
 * @package Pith\ExampleResourcePack
 */
class ExampleResourcePack extends PithPack
{
    public $access_level = 'world';
    public $pack_type    = 'resource-pack';
}