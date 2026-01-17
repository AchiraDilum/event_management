<?php

    session_start();
    require 'db_con.php'; 
    
    $target_db = 'event_management';
    $redirect_login = 'index.php';
    $redirect_dashboard = 'dashboard.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . $redirect_login . '?mode=register');
        exit;
    }

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';


    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['register_error'] = "All fields are required.";
        exit;
    }
    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match.";
        exit;
    }

    $pdo = null;
    try {
        $pdo = open_db_connection();


        $check_sql = "SELECT id FROM {$target_db}.users WHERE user_name = ? OR email = ?";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([$username, $email]);
        
        if ($check_stmt->rowCount() > 0) {
            $_SESSION['register_error'] = "Username or Email is already in use.";
            header('Location: ' . $redirect_login . '?mode=register');
            exit;
        }
        

        $insert_sql = "INSERT INTO {$target_db}.users (user_name, email, password, is_admin) VALUES (?, ?, ?, 0)";
        $insert_stmt = $pdo->prepare($insert_sql);
        $insert_stmt->execute([$username, $email, $password]);


        $_SESSION['login_success'] = "Registration successful! Please log in.";

        $new_user_id = $pdo->lastInsertId();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['user_id'] = $new_user_id;
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = false;

        header('Location: ' . $redirect_dashboard);
        exit;

    } catch (\PDOException $e) {
        error_log("Registration DB Error: " . $e->getMessage());
        $_SESSION['register_error'] = "A server error occurred during registration.";
        header('Location: ' . $redirect_login . '?mode=register');
        exit;
    } finally {
        if ($pdo) { close_db_connection($pdo); }
    }