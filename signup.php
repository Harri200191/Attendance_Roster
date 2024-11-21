<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Signup</title>
</head>
<body>

    <div class="container">
        <header>
            <h1>NUST Attendance Management System</h1>
        </header>

        <main>
            <section class="login-form">
                <h2>Signup</h2>
                <form action="signup-user.php" method="POST">
                <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label for="class">Class:</label>
                        <input type="text" id="class" name="class" placeholder="Enter your class" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Role:</label>
                        <input type="text" id="role" name="role" placeholder="Enter your role" required>
                    </div>
                    <div class="form-group">
                        <button type="submit">Signup!</button>
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
