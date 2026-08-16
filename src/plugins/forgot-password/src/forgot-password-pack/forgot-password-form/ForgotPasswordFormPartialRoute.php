<?php

/**
 * Forgot Password Form Partial Route
 * ----------------------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpClassNamingConventionInspection    - Long class name is ok here.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PRS-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\ForgotPassword;

use Pith\Workflow\PithRoute;

/**
 * Class ForgotPasswordFormPartialRoute
 */
class ForgotPasswordFormPartialRoute extends PithRoute
{
    public string $route_type   = 'partial';
    public string $pack         = '\\Pith\\Framework\\Plugin\\ForgotPassword\\PithForgotPasswordPack';
    public string $access_level = 'world';
    public string $view         = '[^route_folder]/forgot-password-form-partial-view.phtml';
    public string $view_adapter = '\\Pith\\PhtmlViewAdapter2\\PithPhtmlViewAdapter2';
}
