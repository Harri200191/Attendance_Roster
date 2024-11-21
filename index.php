<?php
session_start(); // Start the session

// Check if user is already logged in, if so, redirect them to the attendance page
if (isset($_SESSION['username'])) {
    header("Location: attendance.php");
    exit();
}

// Define dummy credentials (For demonstration purposes, use a database in real apps)
$valid_username = "admin";
$valid_password = "password123"; // In real applications, use hashed passwords

// Initialize error message
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the credentials are correct
    if ($username == $valid_username && $password == $valid_password) {
        // Store user information in the session
        $_SESSION['username'] = $username;

        // Redirect to the attendance page
        header("Location: attendance.php");
        exit();
    } else {
        // Invalid login
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>

    <div class="container">
        <header>
            <h1>NUST Attendance Management System</h1>
        </header>

        <main>
            <section class="login-form">
                <h2>Login</h2>
                <form action="src/login.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit">Login</button>
                    </div>
                </form>
            </section>
        </main>

        <footer>
            <p>&copy; 2024 NUST. All rights reserved.</p>
        </footer>
    </div>

</body>
</html>
