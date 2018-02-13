<?php
require_once ('database-config.inc.php');
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 13-02-2018
 * Time: 09:17
 */
ob_start();

function redirect($nyside) {
    header('Location: '.$nyside);
    exit;
}

function db_connect() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    return $conn;
}

function db_disconnect($conn) {
    if (isset($conn)) {
        mysqli_close($conn);
    }
}

