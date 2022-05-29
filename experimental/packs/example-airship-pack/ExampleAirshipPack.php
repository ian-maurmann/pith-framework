<?php

/**
 * Example Airship Pack
 * --------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

use Pith\Framework\PithPack;

/**
 * Class ExampleAirshipPack
 * @package Pith\ExampleAirshipPack
 */
class ExampleAirshipPack extends PithPack
{
    public $access_level = 'world';
}