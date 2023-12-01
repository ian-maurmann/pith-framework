<?php

test('Array Utility :: flatten( ) can be given a 1D array.', function () {
    $array_utility = new Pith\Framework\Internal\PithArrayUtility();

    $array = [1,22, 333, 4444];

    $result = $array_utility->flatten($array);

    expect($result)->toBe(
        [1,22, 333, 4444]
    );
});

test('Array Utility :: flatten( ) works on jagged arrays.', function () {
    $array_utility = new Pith\Framework\Internal\PithArrayUtility();

    $array = [1,22, 333, 4444, [5,66,777]];

    $result = $array_utility->flatten($array);

    expect($result)->toBe(
        [1,22, 333, 4444, 5, 66, 777]
    );
});