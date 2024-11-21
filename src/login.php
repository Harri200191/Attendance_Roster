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
    <title>Login</title>
</head>
<body>

    <h2>Login Page</h2>

    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>

</body>
</html>
