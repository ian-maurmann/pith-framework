<?php

/**
 * Hindenburg Route
 * ----------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

use Pith\Framework\PithRoute;

/**
 * Class HindenburgRoute
 * @package Pith\ExampleAirshipPack
 */
class HindenburgRoute extends PithRoute
{
    public $route_type   = 'page';
    public $access_level = 'world';
    public $action       = '\\Pith\\ExampleAirshipPack\\HindenburgAction';

    public function __construct()
    {
        // Do nothing for now.
    }
}