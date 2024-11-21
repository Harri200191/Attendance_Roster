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
    // Retrieve email and full name from the form
    $email = $conn->real_escape_string($_POST['email']);
    $fullname = $conn->real_escape_string($_POST['fullname']);

    // Query the database to validate user
    $sql = "SELECT * FROM user WHERE email = '$email' AND fullname = '$fullname'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, set session and redirect to attendance.php
        $_SESSION['email'] = $email;
        $_SESSION['fullname'] = $fullname;

        header("Location: attendance.php");
        exit();
    } else {
        // Redirect back to index.php with an error message
        header("Location: index.php?error=" . urlencode("Invalid email or full name!"));
        exit();
    }
}

// Close the connection
$conn->close();
?>
