<?php
session_start();

try {
    $db = new PDO('sqlite:cebupacific.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // --- DEBUG SCREEN ---
    echo "<h3>Debugging Form Input vs Database:</h3>";
    echo "Email received from form: <strong>'" . htmlspecialchars($email) . "'</strong><br>";
    echo "Password received from form: <strong>'" . htmlspecialchars($password) . "'</strong><hr>";

    $query = "SELECT * FROM Customers WHERE email = :email AND account_status = 'Active'";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "Database Row Found!<br>";
        echo "Password stored in DB: <strong>'" . htmlspecialchars($user['password']) . "'</strong><br><hr>";

        if ($user['password'] === $password) {
            echo "<h2 style='color: green;'>Match Successful! Logging in...</h2>";
            $_SESSION['logged_in'] = true;
            $_SESSION['account_id'] = $user['account_id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            
            // Uncomment the line below once verified to enable auto-redirect
            header("Location: my-account.php");
            exit();
        } else {
            echo "<h2 style='color: red;'>Password Mismatch! The typed password does not equal the database password.</h2>";
        }
    } else {
        echo "<h2 style='color: red;'>No database row found matching email: '" . htmlspecialchars($email) . "'</h2>";
        echo "<p>This usually means your PHP script is reading a different database file than the one open in DB Browser, or the email is spelled differently.</p>";
    }

} else {
    header("Location: login.html");
    exit();
}
?>