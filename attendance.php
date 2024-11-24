<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Database connection
$host = "localhost";
$dbname = "attendance";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user details
$email = $_SESSION['email'];
$user_query = "SELECT * FROM user WHERE email = '$email'";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();

// Get attendance records for the student
$attendance_query = "SELECT a.date, a.status 
                    FROM attendance a
                    WHERE a.student_id = '{$user['id']}'
                    ORDER BY a.date DESC";
$attendance_result = $conn->query($attendance_query);

// Calculate attendance statistics
$total_classes = 0;
$present_count = 0;
$absent_count = 0;
$late_count = 0;

if ($attendance_result && $attendance_result->num_rows > 0) {
    $total_classes = $attendance_result->num_rows;
    
    // Reset the pointer to beginning of result set
    $attendance_result->data_seek(0);
    
    while ($record = $attendance_result->fetch_assoc()) {
        switch ($record['status']) {
            case 'Present':
                $present_count++;
                break;
            case 'Absent':
                $absent_count++;
                break;
            case 'Late':
                $late_count++;
                break;
        }
    }
    
    // Reset pointer again for later use in the table
    $attendance_result->data_seek(0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container { max-width: 800px; }
        .attendance-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .stat-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .attendance-table th, .attendance-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .attendance-table th {
            background-color: #456fa0;
            color: white;
        }
        .status {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .status-present { background-color: #e8f5e9; color: #2e7d32; }
        .status-absent { background-color: #ffebee; color: #c62828; }
        .status-late { background-color: #fff3e0; color: #ef6c00; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Student Attendance Record</h1>
        </header>

        <main>
            <div class="student-info">
                <h2><?php echo htmlspecialchars($user['fullname']); ?></h2>
                <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                <p>Class: <?php echo htmlspecialchars($user['class']); ?></p>
            </div>

            <div class="attendance-stats">
                <div class="stat-card">
                    <h3>Present</h3>
                    <div class="percentage">
                        <?php 
                        echo $total_classes > 0 
                            ? round(($present_count / $total_classes) * 100) . '%'
                            : '0%';
                        ?>
                    </div>
                    <p><?php echo $present_count; ?> days</p>
                </div>

                <div class="stat-card">
                    <h3>Absent</h3>
                    <div class="percentage">
                        <?php 
                        echo $total_classes > 0 
                            ? round(($absent_count / $total_classes) * 100) . '%'
                            : '0%';
                        ?>
                    </div>
                    <p><?php echo $absent_count; ?> days</p>
                </div>

                <div class="stat-card">
                    <h3>Late</h3>
                    <div class="percentage">
                        <?php 
                        echo $total_classes > 0 
                            ? round(($late_count / $total_classes) * 100) . '%'
                            : '0%';
                        ?>
                    </div>
                    <p><?php echo $late_count; ?> days</p>
                </div>
            </div>

            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($attendance_result && $attendance_result->num_rows > 0) {
                        while ($record = $attendance_result->fetch_assoc()) {
                            $status_class = 'status-' . strtolower($record['status']);
                            echo "<tr>
                                    <td>" . date('F j, Y', strtotime($record['date'])) . "</td>
                                    <td><span class='status {$status_class}'>" . 
                                        htmlspecialchars($record['status']) . 
                                    "</span></td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No attendance records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="form-group" style="margin-top: 20px; text-align: center;">
                <a href="logout.php"><button type="button">Logout</button></a>
            </div>
        </main>

        <footer>
            <p>&copy; 2024 NUST. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>