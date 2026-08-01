<?php
try {
    // Connect to your SQLite database
    $pdo = new PDO('sqlite:cebupacific.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>