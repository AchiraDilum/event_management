<?php

    session_start();

    $redirect_page = 'index.php';

    $_SESSION = array();

    session_destroy();

    header('Location: ' . $redirect_page);
    exit;
?>