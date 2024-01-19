<?php
function arrayAssocFill($keys, $fill) {
    return array_fill_keys($keys, $fill);
}

function atOption($a, $b) {
    $selected = ($a === $b) ? "selected" : "";
    return "value='$b' $selected";
}

function isEmpty($text) {
    return empty(trim($text));
}

function isPhoneNumber($input) {
    $normalPattern = '/^\d{10,15}$/';
    $internationalPattern = '/^\+62\d{10,15}$/';

    if (preg_match($internationalPattern, $input)) {
        return "international";
    } elseif (preg_match($normalPattern, $input)) {
        return "local";
    }

    return null;
}

function isEmail($input) {
    return filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
}

function convertPhone62($localNumber) {
    $countryCode = "+62";
    $localNumber = ltrim($localNumber, '0');

    return $countryCode . $localNumber;
}

function getHostFull() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $hostname = $_SERVER['HTTP_HOST'];
    return $protocol . $hostname;
}
?>