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
        "SELECT gastos.id, tb.nome as categoria, ROUND(SUM(valor), 2) as valor, tb.cor as cor, categoria as id_categoria
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
        "SELECT valor, data, id
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

    function dados_do_gasto($con, $id) {
        $query = 
        "SELECT *
        FROM gastos
        WHERE id = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    function dados_da_receita($con, $id) {
        $query = 
        "SELECT *
        FROM receitas
        WHERE id = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    function atualizar_gasto($con, $id, $cat, $val) {
        $cat = htmlspecialchars($cat);
        $id = htmlspecialchars($id);
        $val = htmlspecialchars($val);

        $query = 
        "UPDATE gastos 
        SET categoria = ?, 
        valor = ?
        WHERE id = ?"; 

        $stmt = $con->prepare($query);
        $stmt->bind_param("idi", $cat, $val, $id);
        $stmt->execute();
    }

    function atualizar_receita($con, $id, $val) {
        $id = htmlspecialchars($id);
        $val = htmlspecialchars($val);

        $query = 
        "UPDATE receitas 
        SET valor = ?
        WHERE id = ?"; 

        $stmt = $con->prepare($query);
        $stmt->bind_param("di", $val, $id);
        $stmt->execute();
    }
    
    function excluir_gasto($con, $id) {
        $id = htmlspecialchars($id);

        $query = 
        "DELETE FROM gastos 
        WHERE id = ?"; 

        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    function excluir_receita($con, $id) {
        $id = htmlspecialchars($id);

        $query = 
        "DELETE FROM receitas 
        WHERE id = ?"; 

        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    function gasto_ultimos_meses($con, $id) {
        $id = htmlspecialchars($id);

        $query = 
        "SELECT ROUND(SUM(valor), 2) as valor, DATE_FORMAT(data, '%m/%Y') as data
        FROM gastos
        WHERE id_usuario = ? 
        AND data > DATE_FORMAT(data, '%Y-%m-01')
        GROUP BY DATE_FORMAT(data, '%Y-%m')";

        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    function receitas_ultimos_meses($con, $id) {
        $id = htmlspecialchars($id);

        $query = 
        "SELECT ROUND(SUM(valor), 2) as valor, DATE_FORMAT(data, '%m/%Y') as data
        FROM receitas
        WHERE id_usuario = ? 
        AND data > DATE_FORMAT(data, '%Y-%m-01')
        GROUP BY DATE_FORMAT(data, '%Y-%m')";

        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function editar_categoria($con, $id, $nome, $cor) {
        $id = htmlspecialchars($id);
        $nome = htmlspecialchars($nome);
        $cor = htmlspecialchars($cor);

        $query = 
        "UPDATE categorias 
        SET nome = ?, 
        cor = ?
        WHERE id = ?"; 

        $stmt = $con->prepare($query);
        $stmt->bind_param("ssi", $nome, $cor, $id);
        $stmt->execute();
    }
    function adicionar_receita($con, $usuario, $valor) {
        $valor = htmlspecialchars($valor);
        $usuario = htmlspecialchars($usuario);

        $query = 
        "INSERT INTO receitas
        (valor, id_usuario)
        VALUES (?, ?)";

        $stmt = $con->prepare($query);
        $stmt->bind_param("di", $valor, $usuario);
        $stmt->execute();
    }

    function receitas_mes($con) {
        $query = 
        "SELECT valor, data, id
        FROM receitas
        WHERE MONTH(data) = MONTH(CURDATE())
        ORDER BY data";

        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $res["valores"] = $result->fetch_all(MYSQLI_ASSOC);
        $res["quantidade"] = $result->num_rows;

        return $res;
    }
?>