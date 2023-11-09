<?php

test('Array Utility -> whereAmI( )', function () {
    $array_utility = new Pith\Framework\Internal\PithArrayUtility();
    $result = $array_utility->whereAmI();

    expect($result)->toBe('Pith Array Utility');
});

test('Array Utility -> flatten( ) ---- On 1D array', function () {
    $array_utility = new Pith\Framework\Internal\PithArrayUtility();

    $array = [1,22, 333, 4444];

    $result = $array_utility->flatten($array);

    expect($result)->toBe(
        [1,22, 333, 4444]
    );
});

test('Array Utility -> flatten( ) ---- On jagged array', function () {
    $array_utility = new Pith\Framework\Internal\PithArrayUtility();

    $array = [1,22, 333, 4444, [5,66,777]];

    $result = $array_utility->flatten($array);

    expect($result)->toBe(
        [1,22, 333, 4444, 5, 66, 777]
    );
});