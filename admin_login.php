<?php
    session_start();
    require 'db_con.php';
    $login_error = '';
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === TRUE) {
        header('Location: admin_dashboard.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $target_db = 'event_management'; 
        
        if (empty($username) || empty($password)) {
            $login_error = 'Please enter both username and password.';
        } else {
            $pdo = null; 
            try {
                $pdo = open_db_connection(); 

                $sql = "SELECT id, user_name, password, is_admin FROM {$target_db}.users WHERE user_name = ?";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$username]);
                $user = $stmt->fetch();

                close_db_connection($pdo); 

                if ($user && $password === $user['password']) {

                    if ((bool)$user['is_admin'] === TRUE) {
                        $_SESSION['loggedin'] = TRUE;
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['user_name']; 
                        $_SESSION['is_admin'] = TRUE; 
                        
                        header('Location: admin_dashboard.php');
                        exit;
                    } else {
                        $login_error = 'Access Denied: Only administrators can log in here.';
                    }

                } else {
                    $login_error = 'Invalid username or password.';
                }

            } catch (\PDOException $e) {
                if ($pdo) { close_db_connection($pdo); }
                $login_error = 'A system error occurred. Please try again later.';
                error_log("Admin Login DB Error: " . $e->getMessage()); 
            }
        }
    }
    if (isset($_SESSION['admin_login_error'])) {
        $login_error = $_SESSION['admin_login_error'];
        unset($_SESSION['admin_login_error']); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
   <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <div class="login-container">
        <h2>🔒 Admin Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <label for="username">Admin Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Log in as Admin</button>
        </form>

        <?php
            if (!empty($login_error)) {
                echo '<p class="message">' . htmlspecialchars($login_error) . '</p>';
            }
        ?>
    </div>
</body>
</html>