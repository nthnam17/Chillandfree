<?php

$NEXT_WEEK = (int) date('W') + 1;

return [
    //thời gian bắt đầu
    'SUMMARY_START_HOUR_SETTING' => 1,
    'WEEK_TS' => 604800,
    'DAY_TS' => 86400,

    //ngày bắt đầu trong tuần
    'SUMMARY_START_WEEK_SETTING' => 4,

    'CURRENT_YEAR' => (int) date('Y'),
    'CURRENT_MONTH' => (int) date('m'),
    'CURRENT_WEEK' => (int) date('W'),
    'NEXT_WEEK' => $NEXT_WEEK,

];
