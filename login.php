<?php
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    require_once("php/model/bd.php");
    require_once("php/model/queries.php");

    $db = connect_confins();
    $user = log_user($db, "Enzo", "46070d4bf934fb0d4b06d9e2c46e346944e322444900a435d7d9a95e6d7435f5");

    if ($user) {
        $_SESSION["user"] = $user;
    }
    header("Loaction: index.php");
?>