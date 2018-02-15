<?php
//require_once ('database-config.inc.php');

function redirect($nyside) {
    header('Location: '.$nyside);
    exit;
}

/*function db_connect() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    return $conn;
}

function db_disconnect($conn) {
    if (isset($conn)) {
        mysqli_close($conn);
    }
}*/

function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_requiest() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}
