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
?>