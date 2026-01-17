<?php

    session_start();

    require 'db_con.php';
    $target_db = 'event_management';

    $action = $_POST['action'] ?? '';
    $user_id = $_POST['user_id'] ?? null;
    $redirect_url = 'admin_dashboard.php?tab=users';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        header('Location: ' . $redirect_url);
        exit;
    }

    $pdo = null;
    try {
        $pdo = open_db_connection();
        

        if ($action === 'create' || $action === 'edit') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $is_admin = isset($_POST['is_admin']) ? 1 : 0; 

            if ($action === 'create') {

                $sql = "INSERT INTO {$target_db}.users (user_name, email, password, is_admin) VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$username, $email, $password, $is_admin]);
                
                $_SESSION['message'] = ['type' => 'success', 'text' => 'User "' . htmlspecialchars($username) . '" created successfully.'];

            } elseif ($action === 'edit' && $user_id) {

                $update_fields = "user_name = ?, email = ?, is_admin = ?";
                $params = [$username, $email, $is_admin];


                if (!empty($password)) {
                    $update_fields .= ", password = ?";
                    $params[] = $password; 
                }

                $sql = "UPDATE {$target_db}.users SET {$update_fields} WHERE id = ?";
                $params[] = $user_id;
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
                
                $_SESSION['message'] = ['type' => 'success', 'text' => 'User ID ' . $user_id . ' updated successfully.'];
            }
        

        } elseif ($action === 'delete' && $user_id) {
            

            if ($user_id == $_SESSION['user_id']) {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'You cannot delete your own admin account.'];
            } else {
                $sql = "DELETE FROM {$target_db}.users WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$user_id]);
                
                $_SESSION['message'] = ['type' => 'success', 'text' => 'User ID ' . $user_id . ' deleted successfully.'];
            }
        } else {

            $_SESSION['message'] = ['type' => 'error', 'text' => 'Invalid action or missing required user ID.'];
        }

    } catch (\PDOException $e) {

        $_SESSION['message'] = ['type' => 'error', 'text' => 'Database error: Could not process request.'];
        error_log("User CRUD Error: " . $e->getMessage());

    } finally {
        if ($pdo) { close_db_connection($pdo); }
    }

    header('Location: ' . $redirect_url);
    exit;
?>