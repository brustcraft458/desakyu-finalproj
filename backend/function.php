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

    return preg_match($normalPattern, $input) || preg_match($internationalPattern, $input);
}

function isEmail($input) {
    return filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
}
?>