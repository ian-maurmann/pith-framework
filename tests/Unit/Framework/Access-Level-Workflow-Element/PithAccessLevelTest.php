<?php


/**
 * Access Level Test
 * -----------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Property names with underscores are ok.
 * @noinspection PhpVariableNamingConventionInspection - Short variable names are ok.
 */

declare(strict_types=1);

test('Access Level :: getName( ) is string.', function () {
    $base_access_level = new Pith\Workflow\PithAccessLevel();
    $name = $base_access_level->getName();

    expect($name)->toBeString();
});

test('Access Level :: isAllowedToAccess( ) is bool.', function () {
    $base_access_level = new Pith\Workflow\PithAccessLevel();
    $is_allowed_to_access = $base_access_level->isAllowedToAccess();

    expect($is_allowed_to_access)->toBeBool();
});
