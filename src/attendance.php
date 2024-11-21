<?php
session_start(); // Start the session

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: src/login.php");
    exit();
}

// Get the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Page</title>
</head>
<body>

    <h2>Welcome to the Attendance Page, <?php echo htmlspecialchars($username); ?>!</h2>
    
    <h3>Mark your attendance:</h3>
    <!-- Example attendance form -->
    <form method="POST" action="submit_attendance.php">
        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" required><br><br>

        <label for="status">Attendance Status:</label><br>
        <select id="status" name="status" required>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
            <option value="Late">Late</option>
        </select><br><br>

        <input type="submit" value="Submit Attendance">
    </form>

    <br>
    <a href="logout.php">Logout</a>

</body>
</html>
