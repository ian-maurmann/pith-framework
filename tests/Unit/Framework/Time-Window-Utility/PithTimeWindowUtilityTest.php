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

test('Time Window Utility :: get30MinuteWindowStartDatetime( ) will be at minute 00 in 1st 30min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:29:01');

    $window_start_datetime = $time_window_utility->get30MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:00:00'
    );
});

test('Time Window Utility :: get30MinuteWindowStartDatetime( ) will be at minute 30 in 2nd 30min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:39:01');

    $window_start_datetime = $time_window_utility->get30MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:30:00'
    );
});

test('Time Window Utility :: get20MinuteWindowStartDatetime( ) will be at minute 00 in 1st 20min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:09:01');

    $window_start_datetime = $time_window_utility->get20MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:00:00'
    );
});

test('Time Window Utility :: get20MinuteWindowStartDatetime( ) will be at minute 20 in 2nd 20min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:29:01');

    $window_start_datetime = $time_window_utility->get20MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:20:00'
    );
});

test('Time Window Utility :: get20MinuteWindowStartDatetime( ) will be at minute 40 in 3rd 20min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:59:01');

    $window_start_datetime = $time_window_utility->get20MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:40:00'
    );
});

test('Time Window Utility :: get15MinuteWindowStartDatetime( ) will be at minute 00 in 1st 15min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:09:01');

    $window_start_datetime = $time_window_utility->get15MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:00:00'
    );
});

test('Time Window Utility :: get15MinuteWindowStartDatetime( ) will be at minute 15 in 2nd 15min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:29:01');

    $window_start_datetime = $time_window_utility->get15MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:15:00'
    );
});

test('Time Window Utility :: get15MinuteWindowStartDatetime( ) will be at minute 30 in 3rd 15min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:39:01');

    $window_start_datetime = $time_window_utility->get15MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:30:00'
    );
});

test('Time Window Utility :: get15MinuteWindowStartDatetime( ) will be at minute 45 in 4th 15min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:59:01');

    $window_start_datetime = $time_window_utility->get15MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:45:00'
    );
});

test('Time Window Utility :: get12MinuteWindowStartDatetime( ) will be at minute 00 in 1st 12min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:09:01');

    $window_start_datetime = $time_window_utility->get12MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:00:00'
    );
});

test('Time Window Utility :: get12MinuteWindowStartDatetime( ) will be at minute 12 in 2nd 12min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:19:01');

    $window_start_datetime = $time_window_utility->get12MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:12:00'
    );
});

test('Time Window Utility :: get12MinuteWindowStartDatetime( ) will be at minute 24 in 3rd 12min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:29:01');

    $window_start_datetime = $time_window_utility->get12MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:24:00'
    );
});


test('Time Window Utility :: get12MinuteWindowStartDatetime( ) will be at minute 36 in 4th 12min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:39:01');

    $window_start_datetime = $time_window_utility->get12MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:36:00'
    );
});

test('Time Window Utility :: get12MinuteWindowStartDatetime( ) will be at minute 48 in 5th 12min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:59:01');

    $window_start_datetime = $time_window_utility->get12MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:48:00'
    );
});

test('Time Window Utility :: get10MinuteWindowStartDatetime( ) will be at minute 00 in 1st 10min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:09:01');

    $window_start_datetime = $time_window_utility->get10MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:00:00'
    );
});

test('Time Window Utility :: get10MinuteWindowStartDatetime( ) will be at minute 10 in 2nd 10min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:10:01');

    $window_start_datetime = $time_window_utility->get10MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:10:00'
    );
});

test('Time Window Utility :: get10MinuteWindowStartDatetime( ) will be at minute 20 in 3rd 10min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:29:01');

    $window_start_datetime = $time_window_utility->get10MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:20:00'
    );
});

test('Time Window Utility :: get10MinuteWindowStartDatetime( ) will be at minute 30 in 4th 10min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:33:01');

    $window_start_datetime = $time_window_utility->get10MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:30:00'
    );
});

test('Time Window Utility :: get10MinuteWindowStartDatetime( ) will be at minute 40 in 5th 10min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:47:01');

    $window_start_datetime = $time_window_utility->get10MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:40:00'
    );
});

test('Time Window Utility :: get10MinuteWindowStartDatetime( ) will be at minute 50 in 6th 10min window of hour.', function () {
    $time_window_utility = new Pith\Framework\Internal\PithTimeWindowUtility();

    $given_datetime = DateTime::createFromFormat('Y-m-d H:i:s', '2023-12-26 21:59:59');

    $window_start_datetime = $time_window_utility->get10MinuteWindowStartDatetime($given_datetime);

    expect($window_start_datetime->format('Y-m-d H:i:s'))->toBe(
        '2023-12-26 21:50:00'
    );
});