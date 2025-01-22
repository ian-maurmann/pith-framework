<?php

/**
 * Green & White (Latte) Layout Route
 * --------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedThemePack;

use Pith\Workflow\PithRoute;

/**
 * Class GreenAndWhiteLatteLayoutRoute
 * @package Pith\Framework\SharedThemePack
 */
class GreenAndWhiteLatteLayoutRoute extends PithRoute
{
    public string $pack             = '\\Pith\\Framework\\SharedThemePack\\SharedThemePack';
    public string $route_type       = 'layout';
    public string $access_level     = 'world';
    public string $view_requisition = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLatteLayoutViewRequisition';
    public string $view             = '[^route_folder]/green-and-white-layout-view.latte';
    public string $view_adapter     = '\\Pith\\LatteViewAdapter\\PithLatteViewAdapter';
}