<?php

// Check if the username already exists
$user_emp = $_GET['user_emp'];

// Connect to the database
include 'includes/connect.php';

// Check if the username exists
$sql = "SELECT COUNT(*) FROM users WHERE user_emp = '$user_emp'";
$result = $db->query($sql);

if ($result->fetchColumn() > 0) {
  // The username already exists
  echo "true";
} else {
  // The username does not exist
  echo "false";
}

?>
