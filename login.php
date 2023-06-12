<?php
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    require_once("php/model/bd.php");
    require_once("php/model/queries.php");

    $db = connect_confins();
    $user = log_user($db, "Enzo", "46070d4bf934fb0d4b06d9e2c46e346944e322444900a435d7d9a95e6d7435f5");

    if ($user) {
        $_SESSION["user"] = $user;
    }
    // header("Loaction: index.php");
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confin$</title>

    <link rel="stylesheet" href="bibliotecas/css/bootstrap.css">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">

    <script defer src="bibliotecas/js/jquery.js"></script>
    <script defer src="bibliotecas/js/bootstrap.js"></script>
    <script defer src="bibliotecas/js/masks.jquery.js"></script>
    <script defer src="bibliotecas/js/crypto.js"></script>
    <script defer src="bibliotecas/js/echarts.js"></script>
    <script defer src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
    <script defer src="js/utils.js"></script>
    <script defer src="js/login.js"></script>
</head>
<body>
    <div class="wrapper d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4"></div>
                            <div class="col-4">
                                <img style="height: 112px" src="img/logo2.png">
                            </div>
                            <div class="col-4"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4"></div>
                            <div class="col-4">
                                <input type="text" class="form-control" placeholder="Login" name="login" id="">
                            </div>
                            <div class="col-4"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4"></div>
                            <div class="col-4">
                                <input type="password" class="form-control" placeholder="Senha" name="pass" id="">
                            </div>
                            <div class="col-4"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4"></div>
                            <div class="col-4 d-flex justify-content-center">
                                <button class="btn btn-primary-custom" id="btn-entrar">Entrar</button>
                            </div>
                            <div class="col-4"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</body>
</html>