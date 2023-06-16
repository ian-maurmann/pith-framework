<?php

/**
 * Env-Info: Fixed-Path File Links Route
 * -------------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages;

use Pith\Framework\PithRoute;

/**
 * Class EnvInfoFixedPathFileLinksRoute
 * @package Pith\Framework\SharedInfrastructure\Pages\EnvInfoPages
 */
class EnvInfoFixedPathFileLinksRoute extends PithRoute
{
    public string $route_type   = 'page';
    public string $pack         = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level = 'dev-ip';
    public string $view         = '[^route_folder]/env-info-fixed-path-file-links-view.latte';
    public string $layout       = '\\Pith\\Framework\\SharedThemePack\\EnvInfoLayoutRoute';

    public string $page_title       = 'Fixed-Path File Links - Env Info';
    public string $meta_keywords    = 'Fixed-Path File Links, Env Info, demo, keyword, keywords';
    public string $meta_description = 'Fixed-Path File Links, Env Info Page description here.';
}
