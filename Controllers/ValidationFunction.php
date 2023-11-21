<?php
// validationFunctions.php

// Fungsi sanitasi input
function cleanInput($input) {
    // Trim whitespace
    $input = trim($input);
    // Remove HTML and PHP tags
    $input = strip_tags($input);
    // Convert special characters to HTML entities
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

    return $input;
}

// Fungsi validasi username
function validateUsername($username) {
    // Use a regular expression to validate the username format
    $pattern = '/^[a-zA-Z0-9_]+$/';
    return preg_match($pattern, $username);
}

// Fungsi validasi password
function validatePassword($password) {
    // Check if the password meets certain criteria (e.g., minimum length)
    return strlen($password) >= 8;
}
?>