<?php

test('Time Window Utility :: getYearWindowStartDatetime( ) will be start of year.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $current_datetime = new DateTime('2023-12-26');

    $year_start_datetime = $time_window_utility->getYearWindowStartDatetime($current_datetime);

    expect($year_start_datetime->format('Y-m-d'))->toBe(
        '2023-01-01'
    );
});

test('Time Window Utility :: getMonthWindowStartDatetime( ) will be start of month.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $current_datetime = new DateTime('2023-12-26');

    $year_start_datetime = $time_window_utility->getMonthWindowStartDatetime($current_datetime);

    expect($year_start_datetime->format('Y-m-d'))->toBe(
        '2023-12-01'
    );
});