<?php

/**
 * Pith Login Form Pack
 * --------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\LoginForm;

use Pith\Workflow\PithPack;

/**
 * Class PithLoginFormPack
 */
class PithLoginFormPack extends PithPack
{
    public string $access_level = 'world';
}