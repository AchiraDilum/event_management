<?php

    $host    = 'localhost';
    $user    = 'root';
    $pass    = '';
    $charset = 'utf8mb4';


    $dsn = "mysql:host=$host;charset=$charset";
    

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    function open_db_connection() {
        global $dsn, $user, $pass, $options;
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
            return $pdo;
        } catch (PDOException $e) {

            error_log("Database connection failed: " . $e->getMessage());
            die("A required service is unavailable."); 
        }
    }


    function close_db_connection(&$pdo) {

        $pdo = null; 
    }
?>