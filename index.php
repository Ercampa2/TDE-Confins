<?php
    require_once("php/seguranca.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Confin$</title>

    <link rel="stylesheet" href="bibliotecas/css/bootstrap.css">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
    <!-- <link rel="stylesheet" href="bibliotecas/css/datatables.css"> -->
    <!-- <link rel="stylesheet" href="bibliotecas/css/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">

    <script defer src="bibliotecas/js/jquery.js"></script>
    <script defer src="bibliotecas/js/bootstrap.js"></script>
    <script defer src="bibliotecas/js/masks.jquery.js"></script>
    <script defer src="bibliotecas/js/crypto.js"></script>
    <script defer src="bibliotecas/js/echarts.js"></script>
    <!-- <script defer src="bibliotecas/js/datatables.js"></script> -->
    <script defer src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
    <script defer src="js/utils.js"></script>
    <script defer src="js/home.js"></script>
</head>
<body>
    <div class="wrapper">

        <div class="menuEsquerdo" id="menuEsquerdo">
            
            <div>
                <!-- Botão para fechar o menu lateral -->
                <div class="row mx-0">
                    <div class="col-10"></div>
                    <div class="col-1">
                        <button type="button" class="btn-close mt-2" aria-label="Close" id="btnFecharMenu"></button>
                    </div>
                    <div class="col-1"></div>
                </div>

                <!-- Imagem do usu�rio -->
                <div class="row py-3 mt-1 mx-0">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <div class="imagemUsuario">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="col-3"></div>
                </div>
                
                <!-- Linhas do menu -->
                <div class="row mx-0 fs-2 linhaMenu primeiraLinhaMenu" data-bs-toggle="modal" data-bs-target="#modalAddGasto">
                    <div class="col-1"><i class="bi bi-plus-lg"></i></div>
                    <div class="col-11 text-end">Adicionar Gastos</div>
                </div>
                
                <div class="row mx-0 fs-2 linhaMenu" id="addEntradas" role="button" data-bs-toggle="modal" data-bs-target="#modalAddReceitas">
                    <div class="col-1"><i class="bi bi-plus-lg"></i></div>
                    <div class="col-11 text-end">Adicionar receitas</div>
                </div>

                <div class="row mx-0 fs-2 linhaMenu" id="entradas" role="button" data-bs-toggle="modal" data-bs-target="#modalReceitas">
                    <div class="col-1"><i class="bi bi-cash-stack"></i></div>
                    <div class="col-11 text-end">Receitas do m&ecirc;s</div>
                </div>
                
                <div class="row mx-0 fs-2 linhaMenu" id="addCategoria" role="button" data-bs-toggle="modal" data-bs-target="#modalAddCategoria">
                    <div class="col-1"><i class="bi bi-boxes"></i></div>
                    <div class="col-11 text-end">Adicionar Categoria</div>
                </div>
                <div class="row mx-0 fs-2 linhaMenu" id="editCategoria" role="button" data-bs-toggle="modal" data-bs-target="#modalEditarCategoria">
                    <div class="col-1"><i class="bi bi-pencil"></i></div>
                    <div class="col-11 text-end">Editar Categorias</div>
                </div>
            </div>

            <div>
                <!-- Linhas do menu na parte de baixo -->
                <div class="row mx-0 fs-2 linhaMenu primeiraLinhaMenu" role="button" data-bs-toggle="modal" data-bs-target="#modalNoticias">
                    <div class="col-1"><i class="bi bi-newspaper"></i></div>
                    <div class="col-11 text-end">Not&iacute;cias</div>
                </div>
                
                <!-- <div class="row mx-0 fs-2 linhaMenu">
                    <div class="col-1"><i class="bi bi-gear"></i></div>
                    <div class="col-11 text-end">Configura&ccedil;&otilde;es</div>
                </div> -->
            </div>
        </div>

        <!-- Cabe�alho -->
        <div class="header">
            <button class="botaoMenu" id="botaoMenu"><i class="bi bi-list"></i></button>
            <img style="position: relative; float:right; height: 100%" src="img/logo.png" alt="">
        </div>
        <div class="row mt-5 pt-5">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="graficos" id="graficoInicio"></div>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
        <div class="row mt-5 pt-5">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="graficos" id="graficoMesesSaida"></div>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
        <div class="row mt-5 pt-5">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="graficos" id="graficoMesesEntrada"></div>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <!-- Modais -->

    <!-- Modal Adição de categoria -->
    <div class="modal fade" id="modalAddCategoria" tabindex="-1" aria-labelledby="modalAddCategoria" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 fw-bold" id="exampleModalLabel">Adicionar categoria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAddCategoria">
                        <div class="input-group">
                            <div class="input-group-text">
                                <input type="color" class="form-check-input" name="cor" required>
                            </div>
                            <input type="text" class="form-control" placeholder="Nova categoria..." name="categoria" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="formAddCategoria" class="btn btn-primary-custom fw-bold">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal info receitas -->
    <div class="modal fade" id="modalReceitas" tabindex="-1" aria-labelledby="modalReceitas" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 fw-bold" id="exampleModalLabel">Receitas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="tabelaReceitas">
                        <thead>
                            <tr>
                                <th>
                                    Valor
                                </th>
                                <th>
                                    Data
                                </th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="formAddEntrada" class="btn btn-primary-custom fw-bold">Adicionar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAddReceitas" tabindex="-1" aria-labelledby="modalAddReceitas" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 fw-bold" id="exampleModalLabel">Adicionar entrada</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAddEntrada">
                        <input type="text" id="valorEntrada" class="form-control" placeholder="Nova entrada..." name="valor" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="formAddEntrada" class="btn btn-primary-custom fw-bold">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Adição de gasto -->
    <div class="modal fade" id="modalAddGasto" tabindex="-1" aria-labelledby="modalAddgasto" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 fw-bold" id="exampleModalLabel">Adicionar gasto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAddGasto">
                        <select class="form-control mb-2" name="categoriaGasto" id="categoriaGasto">
                            
                        </select>
                        <input type="text" class="form-control" placeholder="Novo gasto..." id="valorGasto" name="valor" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="formAddGasto" class="btn btn-primary-custom fw-bold">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal info categoria -->
    <div class="modal fade" id="modalCategorias" tabindex="-1" aria-labelledby="modalCategorias" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 fw-bold" id="cabecalhoModalCategorias">Gastos da categoria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="corpoModalCategorias">
                    <table id="tabelaGastos">
                        <thead>
                            <tr>
                                <th>Valor</th>
                                <th>Data</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Noticias -->
    <div class="modal fade" id="modalNoticias" tabindex="-1" aria-labelledby="modalNoticias" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 fw-bold">Not&iacute;cias</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="corpoModalNoticias">
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header headerNoticias text-center">
                                    Valor do D&oacute;lar
                                </div>
                                <div class="card-body fs-2 text-center valorMoeda" id="valorDolar">
                                    R$ 0,00
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header headerNoticias text-center">
                                    Valor do Euro
                                </div>
                                <div class="card-body fs-2 text-center valorMoeda" id="valorEuro">
                                    R$ 0,00
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header headerNoticias text-center">
                                    Taxa Selic
                                </div>
                                <div class="card-body fs-2 text-center valorMoeda" id="valorSelic">
                                    R$ 0,00
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header headerNoticias text-center">
                                    Valor do Bitcoin
                                </div>
                                <div class="card-body fs-2 text-center valorMoeda" id="valorBtc">
                                    R$ 0,00
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header headerNoticias text-center">
                                    Valor do Eherium
                                </div>
                                <div class="card-body fs-2 text-center valorMoeda" id="valorEth">
                                    R$ 0,00
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header headerNoticias text-center">
                                    Valor do Tether
                                </div>
                                <div class="card-body fs-2 text-center valorMoeda" id="valorUsdt">
                                    R$ 0,00
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal editar categoria -->
    <div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalEditarCategorias" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 fw-bold" id="cabecalhoModalCategorias">Gastos da categoria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="corpoModalCategorias">
                    <form id="editcaoCategoria">
                        <select name="categoria" class="form-control" id="categoriasEdicao"></select>
                        <div class="input-group mt-3">
                            <div class="input-group-text">
                                <input type="color" class="form-check-input" name="cor" id="editarCor" required>
                            </div>
                            <input type="text" class="form-control" id="editarNome" name="novoNome">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary-custom" type="submit" form="editcaoCategoria">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal editar gasto -->
    <div class="modal fade" id="modalEditarGasto" tabindex="-1" aria-labelledby="modalEditarGasto" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fs-4 fw-bold">
                    Edição de gastos
                </div>
                <div class="modal-body" id="corpoModalCategorias">
                    <form id="editarGasto">
                        <select class="form-control mb-2" id="categoriaEdicaoGastos" name="categoria"></select>
                        <input type="text" class="form-control" id="valorEdicaoGastos" name="valor" required>
                        <input type="hidden" id="idEdicaoGastos" name="id" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary-custom" type="submit" form="editarGasto">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal editar entrada -->
    <div class="modal fade" id="modalEditarReceita" tabindex="-1" aria-labelledby="modalEditarReceita" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fs-4 fw-bold">
                    Edição de receita
                </div>
                <div class="modal-body" id="corpoModalCategorias">
                    <form id="editarReceita">
                        <input type="text" class="form-control" id="valorEdicaoReceita" name="valor" required>
                        <input type="hidden" id="idEdicaoReceita" name="id" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary-custom" type="submit" form="editarReceita">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>