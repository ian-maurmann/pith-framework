<?php

/**
 * Green & White Layout Route
 * --------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedThemePack;

use Pith\Framework\PithRoute;

/**
 * Class GreenAndWhiteLayoutRoute
 * @package Pith\Framework\SharedThemePack
 */
class GreenAndWhiteLayoutRoute extends PithRoute
{
    public string $pack             = '\\Pith\\Framework\\SharedThemePack\\SharedThemePack';
    public string $route_type       = 'layout';
    public string $access_level     = 'world';
    public string $view_requisition = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutViewRequisition';
    public string $view             = '[^route_folder]/green-and-white-layout-view.phtml';
    public string $view_adapter     = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}