<?php
// authController.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Include function configurations
require('../Function/connection.php');
require('../Function/ValidateFunction.php');
require('../Function/cryption.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $username = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);

    // ... (other validations)

    // Prepare SQL statement to find the user with the given username
    $stmt = $conn->prepare("SELECT id, username, password, session_id FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userId, $dbUsername, $dbPassword, $storedSessionId);
    $stmt->fetch();
    $stmt->close();

    // Verify password
    if ($dbUsername && ($password == decryptData($dbPassword, $decryptionKey))) {
        // Check if the stored session ID matches the current session ID
        if (!empty($storedSessionId) && $storedSessionId !== session_id()) {
            // Different session ID, automatically log out the user
            session_destroy();
            echo "You are already logged in from a different device or session. Please log in again.";
            header("Location: ./login&registration.php");
        }

        // Login successful, set session or other actions
        $_SESSION["username"] = $dbUsername;

        // Regenerate session ID
        session_regenerate_id(true);

        // Get the new session ID
        $newSessionId = session_id();

        // Update the session ID in the database
        $updateStmt = $conn->prepare("UPDATE users SET session_id=? WHERE id=?");
        $updateStmt->bind_param("si", $newSessionId, $userId);
        $updateStmt->execute();
        $updateStmt->close();

        // Redirect to the profile page
        header("Location: /profile.php");
        exit();
    } else {
        // Login failed, display error message
        echo "Login failed. Check your username and password.";
    }

    // Close the database connection
    $conn->close();
}
?>
