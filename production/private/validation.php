<?php

/*
 * Functions to validate user input
 * for different pages
*/

// Function to check if a field is filled

function is_filled($value) {
    return isset($value) && trim($value) !== '';
}

//function to check the min length of input

function min_length($value, $min) {
    $length = strlen($value);
    return $length > $min;
}

// Check to see if it is a valid email

function valid_email($value) {
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
}

//check input is only letters with danish letters too

function only_letters($value) {
    $letter_regex = "/^[a-zA-ZÆØÅæøå]+$/i";
    return preg_match($letter_regex, $value);
}




