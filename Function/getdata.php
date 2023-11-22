<?php
session_start(); // Start the session

// Assume you have a connection to the database in connection.php
require('.connection.php');

// Assigning a value to $_SESSION["username"]
// Note: This should typically be done after successful login, and the value should come from user input or database query.
$_SESSION["username"] = $dbUsername; // Replace this with the actual value

function getUserDataBySession($sessionUsername) {
    global $conn; // Add this line to access the global connection variable

    // Prepare SQL statement to find the user with the given username
    $stmt = $conn->prepare("SELECT id, username, password, email, session_id FROM users WHERE username=?");
    $stmt->bind_param("s", $sessionUsername);
    $stmt->execute();
    $stmt->bind_result($userId, $dbUsername, $dbPassword, $dbEmail, $storedSessionId);
    $stmt->fetch();
    $stmt->close();

    // Check if the user was found
    if ($dbUsername) {
        $userData = array(
            'id' => $userId,
            'username' => $dbUsername,
            'email' => $dbEmail,
            // add other fields as needed
        );
        return $userData;
    } else {
        return null; // User not found
    }
}