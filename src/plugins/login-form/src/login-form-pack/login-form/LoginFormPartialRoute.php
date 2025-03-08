<?php

/**
 * Login Form Partial Route
 * ------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok here.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PRS-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\LoginForm;

use Pith\Workflow\PithRoute;

/**
 * Class LoginFormPartialRoute
 */
class LoginFormPartialRoute extends PithRoute
{
    public string $route_type   = 'partial';
    public string $pack         = '\\Pith\\Framework\\Plugin\\LoginForm\\PithLoginFormPack';
    public string $access_level = 'world';
    public string $view         = '[^route_folder]/login-form-partial-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
