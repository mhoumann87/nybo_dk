<?php

// When a user is verified, this function regenerate a new session id, and write info to the Session
function log_in_admin($admin) {
    session_regenerate_id();
    $_SESSION['admin_id'] = $admin['admin_id'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $admin['admin_firstname'];
    return true;
}

// Logs user out, and deletes info in the Session
function log_out_admin() {
    unset($_SESSION['admin_id']);
    unset($_SESSION['last_login']);
    unset($_SESSION['username']);
}

//Checks to see if the user is logged in
function is_logged_in() {
    return isset($_SESSION['admin_id']);
}

// Function to use on every page that needs to be for loged in users only
function require_login() {
    if(!is_logged_in()) {
        redirect(url_for('/admin/login.php'));
    } else {

    }
}