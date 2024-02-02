<?php

test('Access Level :: getName( ) is string.', function () {
    $base_access_level = new Pith\Framework\PithAccessLevel();
    $name = $base_access_level->getName();

    expect($name)->toBeString();
});

test('Access Level :: isAllowedToAccess( ) is bool.', function () {
    $base_access_level = new Pith\Framework\PithAccessLevel();
    $is_allowed_to_access = $base_access_level->isAllowedToAccess();

    expect($is_allowed_to_access)->toBeBool();
});
