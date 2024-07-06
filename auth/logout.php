<?php
    ob_start();
    session_start();
    unset($_SESSION["login"]);
    unset($_SESSION["user"]);
    unset($_SESSION["unique_id"]);
    setcookie('driver_id', '', time() - 3600, '/'); // Expires immediately
    header("Location: login.php");
    session_unset();
    die();
?>