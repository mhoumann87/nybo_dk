<?php


// Redirecting
function redirect($nyside) {
    header('Location: '.$nyside);
    exit;
}

//Site neutral URLs
function url_for($script_path) {
    // if the leading '/' is forgotten, add it
    if ($script_path[0] != '/') {
        $script_path = '/'.$script_path;
    }
    return WWW_ROOT.$script_path;
}

// Functions for working with HTML

function u($string ="") {
    return urlencode($string);
}

function raw_u($string ="") {
    return rawurlencode($string);
}

function h($string ="") {
    return htmlspecialchars($string);
}

// Control of method
function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_requiest() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

// Clean inout for use in SQL

function clean_input($connection, $string) {
   return mysqli_real_escape_string($connection, $string);
}


