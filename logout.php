<?php
// Start the session
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect back to the home page (or login page)
header("Location: index.php");
exit();
?>