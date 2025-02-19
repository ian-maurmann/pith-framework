<?php

/**
 * Main Layout Route
 * -----------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpIllegalPsrClassPathInspection      - Using PSR-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\Panel\Theme;

use Pith\Workflow\PithRoute;

/**
 * Class MainLayoutRoute
 * @package Pith\Framework\Panel\Theme
 */
class MainLayoutRoute extends PithRoute
{
    public string $pack             = '\\Pith\\Framework\\Panel\\Theme\\PithPanelThemePack';
    public string $route_type       = 'layout';
    public string $access_level     = 'world';
    public string $action           = '\\Pith\\Framework\\Panel\\Theme\\MainLayoutAction';
    public string $view_requisition = '\\Pith\\Framework\\Panel\\Theme\\MainLayoutViewRequisition';
    public string $view             = '[^route_folder]/main-layout-view.latte';
}