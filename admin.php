<?php
session_start();

// // Check if the admin is logged in
// if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin') {
//     header("Location: index.php?error=" . urlencode("Unauthorized access!"));
//     exit();
// }

// Database connection credentials
$host = "localhost";
$dbname = "attendance";
$username = "root";
$password = "";

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users from the database
$sql = "SELECT * FROM user";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <header>
        <h2>Admin Panel</h2>
    </header>
    <div class="container">
        <h1>User Information</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr> 
                        <th>Email</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr> 
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['password']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users found in the database.</p>
        <?php endif; ?>
        <a class="logout" href="logout.php">Logout</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>
