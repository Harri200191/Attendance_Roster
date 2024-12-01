<?php
session_start(); // Start the session

// Database connection credentials
$host = "localhost"; // or the appropriate hostname
$dbname = "attendance"; // database name
$username = "root"; // MySQL username
$password = ""; // MySQL password (default is blank for XAMPP)

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve email and password from the form
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if the user is the admin
    if ($email === 'admin@seecs' && $password === 'seecs123') {
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password; // Optionally set a role for admin
        header("Location: admin.php");
        exit();
    }

    // Query the database to validate user
    $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, set session and redirect to attendance.php
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;

        header("Location: attendance.php");
        exit();
    } else {
        // Redirect back to index.php with an error message
        header("Location: index.php?error=" . urlencode("Invalid email or password!"));
        exit();
    }
}

// Close the connection
$conn->close();
?>
