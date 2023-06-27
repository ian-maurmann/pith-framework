<?php

/**
 * Do Login User Route
 * -------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PRS-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Pages\SharedUiPages;

use Pith\Framework\PithRoute;

/**
 * Class DoLoginUserRoute
 * @package Pith\Framework\SharedInfrastructure\Pages\SharedUiPages
 */
class DoLoginUserRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'do-login-user';
    public string $view         = '[^route_folder]/do-login-user-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';

    public string $page_title = '404 Not Found';
}
