<?php

    session_start();

    require 'db_con.php'; 
    $target_db = 'event_management'; 


    $action = $_POST['action'] ?? '';
    $event_id = $_POST['event_id'] ?? null;
    $redirect_url = 'admin_dashboard.php?tab=events'; 

    $pdo = null;
    try {
        $pdo = open_db_connection();
        

        if ($action === 'create' || $action === 'edit') {
            

            $event_name = trim($_POST['event_name'] ?? '');
            $event_date = trim($_POST['event_date'] ?? '');
            $num_tickets = filter_var($_POST['number_of_tickets'] ?? 0, FILTER_VALIDATE_INT);
            $new_status = 'Active';

            if (empty($event_name) || empty($event_date) || $num_tickets === FALSE || $num_tickets < 1) {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Event Name, Date, and valid Ticket count are required.'];
                header('Location: ' . $redirect_url);
                exit;
            }

            if ($action === 'create') {

                $sql = "INSERT INTO {$target_db}.events (event_name, date, number_of_tickets, status) VALUES (?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$event_name, $event_date, $num_tickets, $new_status]);
                
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Event "' . htmlspecialchars($event_name) . '" created successfully with status: ' . $new_status];

            } elseif ($action === 'edit' && $event_id) {

                $sql = "UPDATE {$target_db}.events SET event_name = ?, date = ?, number_of_tickets = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$event_name, $event_date, $num_tickets, $event_id]);
                
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Event ID ' . $event_id . ' details updated successfully.'];
            }
        

        } elseif ($event_id && ($action === 'cancel' || $action === 'reactivate')) {
            
            $new_status = ($action === 'cancel') ? 'Cancelled' : 'Active';


            $sql = "UPDATE {$target_db}.events SET status = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$new_status, $event_id]);
            

            if ($stmt->rowCount() > 0) {
                 $_SESSION['message'] = ['type' => 'success', 'text' => 'Event ID ' . $event_id . ' status successfully changed to "' . $new_status . '".'];
            } else {
                 $_SESSION['message'] = ['type' => 'error', 'text' => 'Event ID ' . $event_id . ' not found or status already set to "' . $new_status . '".'];
            }
            
        } else {

            $_SESSION['message'] = ['type' => 'error', 'text' => 'Invalid action or missing required event data.'];
        }

    } catch (\PDOException $e) {

        $_SESSION['message'] = ['type' => 'error', 'text' => 'Database error: Could not process event request.'];
        error_log("Event CRUD Error: " . $e->getMessage());

    } finally {
        if ($pdo) { close_db_connection($pdo); }
    }


    header('Location: ' . $redirect_url);
    exit;
?>