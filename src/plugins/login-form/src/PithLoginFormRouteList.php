<?php

/**
 * Pith Login Form route list
 * --------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\LoginForm;

use Pith\Workflow\PithRouteList;

/**
 * Class PithLoginFormRouteList
 */
class PithLoginFormRouteList extends PithRouteList
{
    public array $routes = [
        ['route', 'GET', '/login-resources/{filepath:.+}', '\\Pith\\Framework\\Plugin\\LoginForm\\PithLoginFormResourceRoute'],
    ];
}