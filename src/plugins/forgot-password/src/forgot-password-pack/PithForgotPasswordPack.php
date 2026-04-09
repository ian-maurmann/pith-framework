<?php

/**
 * Pith Forgot-Password Pack
 * -------------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\ForgotPassword;

use Pith\Workflow\PithPack;

/**
 * Class PithForgotPasswordPack
 */
class PithForgotPasswordPack extends PithPack
{
    public string $access_level = 'world';
}