<?php
// Start the session if not already started
session_start();

// Check if 'user_emp' is set in the session
if (isset($_SESSION['user_emp'])) {
    // Unset 'user_emp' to remove the specific session variable
    unset($_SESSION['user_emp']);
}

// Destroy the session
session_destroy();

// Redirect to index.php
header("Location: index.php");
exit(); // Ensure no further code is executed after redirection
?>
