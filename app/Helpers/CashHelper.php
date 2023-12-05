<?php
if (!function_exists('tramsform_cash')) {
    function tramsform_cash($number)
    {
        return 'S/.' . number_format($number, 2, '.', ',');
    }
}

if (!function_exists('round_two_decimals')) {
    function round_two_decimals($number)
    {
        return round($number, 2);
    }
}
