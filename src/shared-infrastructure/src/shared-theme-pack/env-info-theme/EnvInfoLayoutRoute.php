<?php

/**
 * Env Info Layout Route
 * ---------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedThemePack;

use Pith\Framework\PithRoute;

/**
 * Class GreenAndWhiteLatteLayoutRoute
 * @package Pith\Framework\SharedThemePack
 */
class EnvInfoLayoutRoute extends PithRoute
{
    public string $pack             = '\\Pith\\Framework\\SharedThemePack\\SharedThemePack';
    public string $route_type       = 'layout';
    public string $access_level     = 'world';
    public string $view_requisition = '\\Pith\\Framework\\SharedThemePack\\EnvInfoLayoutViewRequisition';
    public string $view             = '[^route_folder]/env-info-layout-view.latte';
    public string $view_adapter     = '\\Pith\\LatteViewAdapter\\PithLatteViewAdapter';
}