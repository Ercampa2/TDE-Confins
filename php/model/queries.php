<?php
    //Login 
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

    // Categorias
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

    // Gastos
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

    function gastos_do_mes($con, $usuario) {
        $usuario = htmlspecialchars($usuario);

        $query = 
        "SELECT gastos.id, tb.nome as categoria, SUM(valor) as valor, tb.cor as cor, categoria as id_categoria
        FROM gastos
        INNER JOIN (
            SELECT id, nome, cor
            FROM categorias 
            WHERE id_usuario = ?
            ) as tb
        ON categoria = tb.id
        WHERE id_usuario = ?
        AND MONTH(data) = MONTH(CURDATE())
        GROUP BY categoria";

        $stmt = $con->prepare($query);
        $stmt->bind_param("ii", $usuario, $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $res["valores"] = $result->fetch_all(MYSQLI_ASSOC);
        $res["quantidade"] = $result->num_rows;

        return $res;
    }

    function gastos_da_categoria($con, $categoria) {
        $categoria = htmlspecialchars($categoria);

        $query = 
        "SELECT valor, DATE_FORMAT(data, '%d/%m/%Y') as data
        FROM gastos
        WHERE categoria = ?
        AND MONTH(data) = MONTH(CURDATE())
        ORDER BY data";

        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $categoria);
        $stmt->execute();
        $result = $stmt->get_result();
        $res["valores"] = $result->fetch_all(MYSQLI_ASSOC);
        $res["quantidade"] = $result->num_rows;

        return $res;
    }

    function dadosCategoria($con, $cat) {
        $cat = htmlspecialchars($cat);

        $query = 
        "SELECT nome, id, cor
        FROM categorias
        WHERE id = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $cat);
        $stmt->execute();
        $result = $stmt->get_result();
        $res["dados"] = $result->fetch_assoc();
        $res["quantidade"] = $result->num_rows;

        return $res;
    }
?>