<?php

/**
 * Hindenburg Route
 * ----------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

/**
 * Class HindenburgRoute
 * @package Pith\ExampleAirshipPack
 */
class HindenburgRoute
{
    public $access_level = 'world';
    public $action       = '\\Pith\\ExampleAirshipPack\\HindenburgAction';

    public function __construct()
    {
        // Do nothing for now.
    }
}