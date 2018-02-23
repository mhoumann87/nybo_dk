<?php

//==============================ADMINS======================================================

//Find all admins
function find_all_admins() {
    global $db;
    $sql = $sql = "SELECT * FROM admins";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
    mysqli_free_result($result);
}


//Check to see if an admin with this email already is in the database
function admin_exist($email) {
    global $db;
    $sql = "SELECT * FROM admins WHERE 	admin_mail = '".trim(clean_input($db, $email))."'";
    $result = mysqli_query($db, $sql);
    return mysqli_num_rows($result);
    mysqli_free_result($result);
}


// Find admin by email
function find_admin_by_email($email) {
    global $db;

    $sql = "SELECT * FROM admins WHERE admin_mail = '".trim(clean_input($db, $email))."' LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    return $admin;
    mysqli_free_result($result);
}

// Find admin by id
function find_admin_by_id($id) {
    global $db;

    $sql = "SELECT * FROM admins WHERE admin_id = '".trim(clean_input($db, $id))."' LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    return $admin;
    mysqli_free_result($result);
}

//===================================================Billeder====================================

// Check to see if this photo title is all ready in use

function title_exist($titel) {
    global $db;

    $sql = "SELECT * FROM billeder WHERE billede_titel = '".trim(clean_input($db, $titel))."' LIMIT 1";
    $result = mysqli_query($db, $sql);
    return mysqli_num_rows($result);
    mysqli_free_result($result);
}

function get_all_photos() {
    global $db;

    $sql = "SELECT * FROM billeder ORDER BY billede_upload DESC ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $result_set = mysqli_fetch_assoc($result);
    return $result_set;
    mysqli_free_result($result);
}

function find_photos_by_category($cat) {
    global $db;

    $sql = "SELECT * FROM billeder WHERE billede_kategori = '".trim(clean_input($db, $cat))."' ORDER BY billede_upload DESC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $result_set = mysqli_fetch_assoc($result);
    return $result_set;
    mysqli_free_result($result);
}

function find_all_photos() {
    global $db;

    $sql = "SELECT * FROM billeder ORDER BY billede_upload DESC ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $photo_set = mysqli_fetch_assoc($result);
    return $photo_set;
    mysqli_free_result($result);
}

function find_photos_by_id($id) {
    global $db;

    $sql = "SELECT * FROM billeder WHERE billede_kategori = '".trim(clean_input($db, $id))."' LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $photo = mysqli_fetch_assoc($result);
    return $photo;
    mysqli_free_result($result);
}

//Create post in database

function query_sql($sql) {
    global $db;
   return mysqli_query($db, $sql);
}