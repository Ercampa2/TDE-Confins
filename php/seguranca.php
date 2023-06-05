<?php 
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();

    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit;
    }

    $id_usuario = $_SESSION["user"];
?>