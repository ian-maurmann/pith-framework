<?php /** @noinspection PhpClassNamingConventionInspection */

/**
 * Env Info - Server Info Route
 * ----------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Framework\PithRoute;

/**
 * Class EnvInfoServerInfoRoute
 * @package Pith\Framework\SharedInfrastructure
 */
class EnvInfoServerInfoRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'dev-ip';
    public string $action       = '\\Pith\\Framework\\SharedInfrastructure\\EnvInfoServerInfoAction';
    public string $view         = '[^route_folder]/env-info-server-info-view.latte';
    public string $layout       = '\\Pith\\Framework\\SharedThemePack\\EnvInfoLayoutRoute';

    public string $page_title       = 'Server Info';
    public string $meta_keywords    = 'Env Info, demo, keyword, keywords';
    public string $meta_description = 'Env Info Page description here.';
}
