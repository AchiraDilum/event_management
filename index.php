<?php

    session_start();


    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE) {
        header('Location: dashboard.php');
        exit;
    }
    

    $message = $_SESSION['login_error'] ?? null;
    unset($_SESSION['login_error']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Event Management</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <div class="login-container">
        <h2>Event Manager Login</h2>

        <?php if ($message): ?>
            <p class="error"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form action="process_login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Log In</button>
        </form>

        <div style="margin-top: 15px; text-align: center;">
            Dont have an account? 
            <a href="register.php" style="color: #274b72; text-decoration: none; font-weight: bold;">
            Register here.
            </a>
        </div>
    </div>
</body>
</html>