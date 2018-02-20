<?php

// checks information and log in admin

function log_in_admin($admin) {

    session_regenerate_id();
    $_SESSION['admin_id'] = $admin['admin_id'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $admin['admin_firstname'];
    return true;
}