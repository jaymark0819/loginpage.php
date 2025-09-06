<?php
include "./confdb.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Basic security measure - prevent SQL injection
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Query to check if admin user exists
    $sql = "SELECT * FROM login_page WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Use password_verify if password is hashed (RECOMMENDED)
        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            // Redirect to dashboard or protected page
            $conn->close();
            header("Location: dashboard.php");
            exit;
        } else {
            // Redirect back with error
            $conn->close();
            header("Location: login.php?error=invalid");
            exit;
        }
    } else {
        // Redirect back with error
        $conn->close();
        header("Location: index.php?error=invalid");
        exit;
    }
}
?>

