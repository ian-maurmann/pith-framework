<?php

/**
 * Pith Sign-Up Form pack
 * ----------------------
 *
 * @noinspection PhpClassNamingConventionInspection    - Long class names are ok.
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\SignUpForm;

use Pith\Workflow\PithPack;

/**
 * Class PithSignUpFormPack
 */
class PithSignUpFormPack extends PithPack
{
    public string $access_level = 'world';
}