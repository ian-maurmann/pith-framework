<?php

/**
 * Reset Password Route
 * --------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Ignore.
 * @noinspection PhpIllegalPsrClassPathInspection      - Ignore, using PRS-4 not PSR-0.
 */


declare(strict_types=1);

namespace Pith\Framework\SharedInfrastructure;

use Pith\Workflow\PithRoute;

/**
 * Class ResetPasswordRoute
 */
class ResetPasswordRoute extends PithRoute
{
    public string $route_type       = 'page';
    public string $pack             = '\\Pith\\Framework\\SharedInfrastructure\\SharedInfrastructurePack';
    public string $access_level     = 'dev-ip';
    public string $view_requisition = '\\Pith\\Framework\\SharedInfrastructure\\ResetPasswordViewRequisition';
    public string $view             = '[^route_folder]/reset-password-view.latte';
    public string $layout           = '\\Pith\\Framework\\SharedThemePack\\GreenAndWhiteLayoutRoute';

    public string $page_title       = 'Reset Password - ' . PITH_DEMO_PAGE_MAIN_TITLE;
    public string $meta_keywords    = 'reset password, demo, keyword, keywords';
    public string $meta_description = 'Reset Password. Reset password page description here.';
}
