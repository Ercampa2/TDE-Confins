<?php
    function log_user($con, $nome, $hash) {
        $nome = htmlspecialchars($nome);
        $hash = htmlspecialchars($hash);
        $res = "";
        
        $query = 
        "SELECT id 
        FROM usuarios 
        WHERE nome = ? 
        AND senha = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $nome, $hash);
        $stmt->execute();
        $stmt->bind_result($res);
        $stmt->fetch();

        return $res;
    }

    function add_categoria($con, $categoria, $cor, $id_usuario) {
        $categoria = htmlspecialchars($categoria);
        $cor = htmlspecialchars($cor);
        
        $query = 
        "INSERT INTO categorias (id_usuario, nome, cor, limite)
        VALUES (?, ?, ?, 0)";

        $stmt = $con->prepare($query);
        $stmt->bind_param("iss", $id_usuario, $categoria, $cor);
        $stmt->execute();
    }

    function categorias_usuario ($con, $id) {
        $res = [];

        $query = 
        "SELECT nome, cor, id
        FROM categorias 
        WHERE id_usuario = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $res["categorias"] = $result->fetch_all(MYSQLI_ASSOC);
        $res["quantidade"] = $result->num_rows;

        return $res;
    }

    function add_gasto ($con, $categoria, $valor, $usuario) {
        $categoria = intval(htmlspecialchars($categoria));
        $valor = htmlspecialchars($valor);
        $usuario = htmlspecialchars($usuario);

        $query = 
        "INSERT INTO gastos
        (categoria, valor, id_usuario)
        VALUES (?, ?, ?)";

        $stmt = $con->prepare($query);
        $stmt->bind_param("idi", $categoria, $valor, $usuario);
        $stmt->execute();
    }
?>