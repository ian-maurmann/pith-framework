<?php

/**
 * Yellow Jello Pack
 * -----------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack;

use Pith\Framework\PithPack;

/**
 * Class YellowJelloPack
 * @package Pith\Framework\Test\TestPage\TestPageOne\YellowJelloPack
 */
class YellowJelloPack extends PithPack
{
    public string $access_level = 'world';
}