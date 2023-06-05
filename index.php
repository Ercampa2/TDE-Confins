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
    <!-- <link rel="stylesheet" href="bibliotecas/css/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">

    <script defer src="bibliotecas/js/bootstrap.js"></script>
    <script defer src="bibliotecas/js/jquery.js"></script>
    <script defer src="bibliotecas/js/masks.jquery.js"></script>
    <script defer src="bibliotecas/js/crypto.js"></script>
    <script defer src="bibliotecas/js/echarts.js"></script>
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

                <!-- Imagem do usuário -->
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
                
                <!-- <div class="row mx-0 fs-2 linhaMenu" id="addEntradas">
                    <div class="col-1"><i class="bi bi-plus-lg"></i></div>
                    <div class="col-11 text-end">Adicionar entradas</div>
                </div> -->
                
                <div class="row mx-0 fs-2 linhaMenu" id="addCartao">
                    <div class="col-1"><i class="bi bi-credit-card"></i></div>
                    <div class="col-11 text-end">Adicionar Cart&atilde;o</div>
                </div>
                
                <div class="row mx-0 fs-2 linhaMenu" id="addCategoria" role="button" data-bs-toggle="modal" data-bs-target="#modalAddCategoria">
                    <div class="col-1"><i class="bi bi-boxes"></i></div>
                    <div class="col-11 text-end">Adicionar Categoria</div>
                </div>
                <div class="row mx-0 fs-2 linhaMenu" id="editCategoria" role="button" data-bs-toggle="modal" data-bs-target="#">
                    <div class="col-1"><i class="bi bi-pencil"></i></div>
                    <div class="col-11 text-end">Editar Categorias</div>
                </div>
            </div>

            <div>
                <!-- Linhas do menu na parte de baixo -->
                <div class="row mx-0 fs-2 linhaMenu primeiraLinhaMenu">
                    <div class="col-1"><i class="bi bi-newspaper"></i></div>
                    <div class="col-11 text-end">Not&iacute;cias</div>
                </div>
                
                <div class="row mx-0 fs-2 linhaMenu">
                    <div class="col-1"><i class="bi bi-gear"></i></div>
                    <div class="col-11 text-end">Configura&ccedil;&otilde;es</div>
                </div>
            </div>
        </div>

        <!-- Cabeçalho -->
        <div class="header">
            <button class="botaoMenu" id="botaoMenu"><i class="bi bi-list"></i></button>
        </div>
    </div>
    <!-- Modais -->

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
                            <option value="" selected disabled>--Selecione uma categoria--</option>
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
</div>
</body>
</html>