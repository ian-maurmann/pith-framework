<?php

/**
 * Env Info Route
 * --------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages;

use Pith\Workflow\PithRoute;

/**
 * Class EnvInfoRoute
 * @package Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages
 */
class EnvInfoRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'dev-ip';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\Pages\\EnvInfoPages\\EnvInfoAction';
    public string $view         = '[^route_folder]/env-info-view.latte';
    public string $layout       = '\\Pith\\Framework\\SharedThemePack\\EnvInfoLayoutRoute';

    public string $page_title       = 'Env Info';
    public string $meta_keywords    = 'Env Info, demo, keyword, keywords';
    public string $meta_description = 'Env Info Page description here.';
}
