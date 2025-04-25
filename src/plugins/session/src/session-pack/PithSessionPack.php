<?php

/**
 * Pith Session Pack
 * ----------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\Session;

use Pith\Workflow\PithPack;

/**
 * Class PithSessionPack
 * @package Pith\Framework\Plugin\Session
 */
class PithSessionPack extends PithPack
{
    public string $access_level = 'world';
} 