<?php
require_once("../seguranca.php");
require_once("../model/bd.php");
require_once("../model/queries.php");


if (!isset($_POST["controller"])) { // verifica se o controlador est� definido
    $_POST = json_decode(file_get_contents('php://input'), true); // Handler para o fetch
    if (!isset($_POST["controller"])) exit;
}

$bd = connect_confins();

$ctrl = $_POST["controller"];

if ($ctrl == "addCategoria") { // Adi��o de categoria
    $categoria = $_POST["categoria"];
    $cor = $_POST["cor"];
    add_categoria($bd, $categoria, $cor, $id_usuario);
    $res["user"] = $id_usuario;

} else if ($ctrl == "graficoCategorias") { // Puxa os dados das categorias ao carregarr a p�gina
    $res["dadosCategoria"] = categorias_usuario($bd, $id_usuario); 

} else if ($ctrl == "addGasto") { // Adi��o de gastos
    $categoria = $_POST["categoria"];
    $valor = $_POST["valor"];
    add_gasto($bd, $categoria, $valor, $id_usuario);
}

echo json_encode($res);
exit;