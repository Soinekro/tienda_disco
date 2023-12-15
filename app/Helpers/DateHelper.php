<?php

use Carbon\Carbon;

if (!function_exists('date_for_humans')) {
    function date_for_humans($date)
    {
        return Carbon::parse($date)->isoFormat('ll'); // 20 de enero de 2020
    }
}

if (!function_exists('format_date')) {
    function format_date($date)
    {
        return Carbon::parse($date)->format('Y-m-d'); // 2020-01-20
    }
}
