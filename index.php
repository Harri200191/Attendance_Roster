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

                <!-- Display error message if any -->
                <?php if (isset($_GET['error'])): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
                <?php endif; ?>

                <form action="login-user.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="fullname">Full Name:</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Enter your Full Name" required>
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
