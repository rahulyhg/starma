<?php

function remove_slashes($string) {
    $string = implode("",explode("\\",$string));
    return stripslashes(trim($string));
}

function remove_front_slashes($string) {
    $string = implode("",explode("/",$string));
    return stripslashes(trim($string));
}

?>