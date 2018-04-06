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

function is_get_request() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

// Clean inout for use in SQL

function clean_input($connection, $string) {
   return mysqli_real_escape_string($connection, $string);
}

// Set status in header to an error code

function error_404($id = '') {
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
    redirect(url_for('/err_404.php?id='.$id.''));
    exit();
}

function error_500() {
    header($_SERVER['SERVER_PROTOCOL']." 500 Internal Server Error");
    redirect(url_for('/err_500.php'));
    exit();
}

// Calculate filesize

function convert_to_bytes($size) {
    $size = trim($size);
    $last = strtolower($size[strlen($size) - 1]);

    if (in_array($last, array('g', 'm', 'k'))) {
        switch ($last) {
            case 'g':
                $size *= 1024;
            case 'm':
                $size *= 1024;
            case 'k':
                $size *= 1024;
        }
    }
    return $size;
}


