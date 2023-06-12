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

if ($ctrl == "addCategoria") { // Adição de categoria
    $categoria = $_POST["categoria"];
    $cor = $_POST["cor"];

    add_categoria($bd, $categoria, $cor, $id_usuario);
    $res["user"] = $id_usuario;

} else if ($ctrl == "graficoCategorias") { // Puxa os dados das categorias ao carregarr a p�gina
    $res["dadosCategoria"] = categorias_usuario($bd, $id_usuario); 
    $res["dadosGrafico"] = gastos_do_mes($bd, $id_usuario);

} else if ($ctrl == "addGasto") { // Adição de gastos
    $categoria = $_POST["categoria"];
    $valor = $_POST["valor"];

    add_gasto($bd, $categoria, $valor, $id_usuario);

} else if ($ctrl == "gastosCategoria") {
    $categoria = $_POST["categoria"];

    $res["gastos"] = gastos_da_categoria($bd, $categoria);
    $res["categoria"] = dadosCategoria($bd, $categoria);

} else if ($ctrl == "listargemReceitas") {
    $res = receitas_mes($bd);

} else if($ctrl == "editarGasto") {
    $id = $_POST["id"];
    $gastos = dados_do_gasto($bd, $id);
    $res["gasto"] = $gastos;
    $res["categorias"] = categorias_usuario($bd, $id_usuario); 
    $res["categoriaGasto"] = dadosCategoria($bd, $gastos["categoria"]);

} else if($ctrl == "editarReceita") {
    $id = $_POST["id"];
    $res["receita"] = dados_da_receita($bd, $id);

} else if($ctrl == "editarValoresGasto") {
    $id = $_POST["id"];
    $categoria = $_POST["categoria"];
    $valor = $_POST["valor"];

    atualizar_gasto($bd, $id, $categoria, $valor);

} else if($ctrl == "editarValorReceita") {
    $id = $_POST["id"];
    $valor = $_POST["valor"];

    atualizar_receita($bd, $id, $valor);

} else if($ctrl == "excluirGasto") {
    excluir_gasto($bd, $_POST["id"]);

} else if($ctrl == "excluirReceita") {
    excluir_receita($bd, $_POST["id"]);

} else if($ctrl == "graficoMeses") {
    $res["dados"] = gasto_ultimos_meses($bd, $id_usuario);
    $res["dados2"] = receitas_ultimos_meses($bd, $id_usuario);

} else if($ctrl == "categoriasEdicao") {
    $res = categorias_usuario($bd, $id_usuario); 

} else if ($ctrl == "dadosCategoria") {
    $res = dadosCategoria($bd, $_POST["categoria"]);

} else if($ctrl == "editarCategoria") {
    $categoria = $_POST["categoria"];
    $cor = $_POST["cor"];
    $nome = $_POST["novoNome"];
    editar_categoria($bd, $categoria, $nome, $cor);

} else if($ctrl == "addEntrada") {
    adicionar_receita($bd, $id_usuario, $_POST["valor"]);
}

echo json_encode($res);
exit;