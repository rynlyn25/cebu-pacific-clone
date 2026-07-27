<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // If not logged in, block them and send them back to login
    echo "<div style='font-family: Arial, sans-serif; text-align: center; padding: 50px;'>";
    echo "<h2 style='color: #c8102e;'>Authentication Required</h2>";
    echo "<p>You must be logged in to search and book flights.</p>";
    echo "<a href='login.html' style='color: #0088CE; text-decoration: none; font-weight: bold;'>Log in now</a>";
    echo "</div>";
    exit();
}
?>