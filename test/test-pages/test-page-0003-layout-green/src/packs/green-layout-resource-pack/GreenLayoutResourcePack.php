<?php

/**
 * Green Layout Resource Pack
 * --------------------------
 *
 * pack namespace: "Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample\GreenLayoutResourcePack"
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample;

use Pith\Framework\PithPack;

/**
 * Class ExampleResourcePack
 * @package Pith\Framework\Test\TestPage\TestPageThree\GreenLayoutExample
 */
class GreenLayoutResourcePack extends PithPack
{
    public string $access_level = 'world';
    public string $pack_type    = 'resource-pack';
}