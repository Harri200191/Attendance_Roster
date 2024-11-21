<?php
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user data from the form
    $fullname = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $class = $conn->real_escape_string($_POST['class']);
    $role = $conn->real_escape_string($_POST['role']);

    // Prepare the SQL query
    $sql = "INSERT INTO user (fullname, email, class, role) VALUES ('$fullname', '$email', '$class', '$role')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Redirect to login.php on success
        header("Location: index.php");
        exit();
    } else {
        // Redirect back to signup.php on error
        header("Location: signup.php?error=" . urlencode("Error: " . $conn->error));
        exit();
    }
}

// Close the connection
$conn->close();
?>
