<?php

/**
 * Index Route
 * -----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\ExampleAirshipPack;

/**
 * Class IndexRoute
 * @package Pith\ExampleAirshipPack
 */
class IndexRoute
{
    public $access_level = 'world';
    public $action       = '\\Pith\\ExampleAirshipPack\\IndexAction';

    public function __construct()
    {
        // Do nothing for now.
    }
}