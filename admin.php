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

// Get all unique classes
$class_query = "SELECT DISTINCT class FROM user WHERE role = 'student'";
$class_result = $conn->query($class_query);
$classes = [];
while ($row = $class_result->fetch_assoc()) {
    $classes[] = $row['class'];
}

// Handle attendance submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_attendance'])) {
    $date = $_POST['date'];
    $class = $_POST['class'];
    
    // Check if attendance data exists
    if (isset($_POST['attendance']) && is_array($_POST['attendance'])) {
        foreach ($_POST['attendance'] as $student_id => $status) {
            $sql = "INSERT INTO attendance (student_id, date, status) 
                    VALUES ('$student_id', '$date', '$status')
                    ON DUPLICATE KEY UPDATE status = '$status'";
            if ($conn->query($sql)) {
                $success_message = "Attendance recorded successfully!";
            } else {
                $error_message = "Error recording attendance: " . $conn->error;
            }
        }
    } else {
        $error_message = "No attendance data submitted.";
    }
}

// Get selected class (either from POST or first class in list)
$selected_class = isset($_POST['class']) ? $_POST['class'] : (isset($classes[0]) ? $classes[0] : '');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Attendance Management</title>
    <link rel="stylesheet" href="attendance.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Attendance Management Dashboard</h1>
        </header>

        <main>
            <?php if (isset($success_message)): ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <?php if (isset($error_message)): ?>
                <div class="error-message" style="color: red; background: #ffebee; padding: 10px; border-radius: 4px; margin: 10px 0;">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <div class="attendance-form">
                <form method="POST">
                    <div class="attendance-controls">
                        <div class="form-group">
                            <label for="date">Date:</label>
                            <input type="date" id="date" name="date" required 
                                   value="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="form-group">
                            <label for="class">Select Class:</label>
                            <select id="class" name="class" required>
                                <?php foreach ($classes as $class): ?>
                                    <option value="<?php echo htmlspecialchars($class); ?>"
                                            <?php echo ($selected_class === $class) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($class); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <?php
                    if ($selected_class) {
                        $students_query = "SELECT * FROM user WHERE role = 'student' AND class = '$selected_class'";
                        $students_result = $conn->query($students_query);
                        
                        if ($students_result && $students_result->num_rows > 0):
                    ?>
                        <table class="student-list">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Attendance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($student = $students_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($student['fullname']); ?></td>
                                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                                        <td>
                                            <select name="attendance[<?php echo $student['id']; ?>]" 
                                                    class="status-select" required>
                                                <option value="Present">Present</option>
                                                <option value="Absent">Absent</option>
                                                <option value="Late">Late</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <div class="form-group" style="margin-top: 20px;">
                            <button type="submit" name="submit_attendance">Submit Attendance</button>
                        </div>
                    <?php 
                        else:
                    ?>
                        <p>No students found in this class.</p>
                    <?php
                        endif;
                    }
                    ?>
                </form>
            </div>
        </main>

        <footer>
            <p><a href="logout.php">Logout</a></p>
            <p>&copy; 2024 NUST. All rights reserved.</p>
        </footer>
    </div>

    <script>
        // Auto-submit form when class selection changes
        document.getElementById('class').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
</body>
</html>