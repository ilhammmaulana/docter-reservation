<?php


if (!function_exists('formatErrorValidation')) {
    function formatErrorValidatioon($errors)
    {
        $formattedErrors = [];
        foreach ($errors->toArray() as $field => $messages) {
            foreach ($messages as $message) {
                $formattedErrors[] = [
                    'param' => $field,
                    'message' => $message
                ];
            }
        }
        return $formattedErrors;
    }
}
if (!function_exists('generateOTP')) {
    function generateOTP()
    {
        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        return $otp;
    }
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($number)
    {
        return "Rp. " . number_format($number, 2, ",", ".");
    }
}

if (!function_exists('decode_rupiah_to_decimal')) {
    function decode_rupiah_to_decimal($str)
    {
        $cleanedStr = str_replace(['Rp', '.', ' '], '', $str);
        $decimalValue = str_replace(',', '.', $cleanedStr);
        return floatval($decimalValue);
    }
}
