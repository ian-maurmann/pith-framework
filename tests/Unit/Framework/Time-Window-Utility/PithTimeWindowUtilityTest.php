<?php

test('Time Window Utility :: getYearWindowStartDatetime( ) will be start of year.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = new DateTime('2023-12-26');

    $year_start_datetime = $time_window_utility->getYearWindowStartDatetime($given_datetime);

    expect($year_start_datetime->format('Y-m-d'))->toBe(
        '2023-01-01'
    );
});

test('Time Window Utility :: getMonthWindowStartDatetime( ) will be start of month.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = new DateTime('2023-12-26');

    $month_start_datetime = $time_window_utility->getMonthWindowStartDatetime($given_datetime);

    expect($month_start_datetime->format('Y-m-d'))->toBe(
        '2023-12-01'
    );
});

test('Time Window Utility :: getDayWindowStartDatetime( ) will be start of day.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:39:01');

    $day_start_datetime = $time_window_utility->getDayWindowStartDatetime($given_datetime);

    expect($day_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 00:00:00'
    );
});


test('Time Window Utility :: getHourWindowStartDatetime( ) will be start of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:39:01');

    $hour_start_datetime = $time_window_utility->getHourWindowStartDatetime($given_datetime);

    expect($hour_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:00:00'
    );
});

test('Time Window Utility :: get30MinuteWindowStartDatetime( ) will be 00 in 1st 30min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:29:01');

    $hour_start_datetime = $time_window_utility->get30MinuteWindowStartDatetime($given_datetime);

    expect($hour_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:00:00'
    );
});

test('Time Window Utility :: get30MinuteWindowStartDatetime( ) will be 30 in 2nd 30min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:39:01');

    $hour_start_datetime = $time_window_utility->get30MinuteWindowStartDatetime($given_datetime);

    expect($hour_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:30:00'
    );
});