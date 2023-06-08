// dados iniciais
    fetch("php/controllers/home.php", {
        method: "POST",
        body: JSON.stringify({
            controller: "graficoCategorias"
        }),
        headers: {"Content-type": "application/json; charset=UTF-8"}
    })
    .then(res => res.json())
    .then(res => {
        let categorias = [];
        let ids = [];
        let cores = [];

        let selectCategorias = "<option value='' selected disabled>--Selecione uma categoria--</option>"

        res.dadosCategoria.categorias.forEach(element => {
            categorias.push(element.nome);
            ids.push(element.id);
            cores.push(element.cor);

            selectCategorias += `<option value="${element.id}">${element.nome}</option>`;
        });

        $("#categoriaGasto").html(selectCategorias);
        
        if (res.dadosCategoria.quantidade > 0) {
            if (res.dadosGrafico.quantidade > 0){

                let grafico = $("#graficoInicio")[0];
                let myChart = echarts.init(grafico);

                let dados = [];
                let cores = []

                res.dadosGrafico.valores.forEach(element => {
                    dados.push({
                        value: element.valor,
                        name: element.categoria,
                        id_categ: element.id_categoria
                    });

                    cores.push(element.cor);
                })
                
                let option = {
                    title: {
                        text: 'Gastos do mÃªs por categoria',
                        left: 'center',
                        textStyle: {
                            color: "#292f2e"
                        }
                    },
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left',
                        textStyle: {
                            color: "#292f2e"
                        }
                    },
                    series: [
                        {
                            name: "gastosMes",
                            type: "pie",
                            radius: "50%",
                            data: dados,
                            label: {
                                color: "#292f2e"
                            }
                        }
                    ],
                    color: cores
                };

                definirGrafico("graficoInicio", option);

                myChart.on("click", abrirModalCategorias)
            } else {
                $("#graficoInicio").text("Nenhum valor gasto ainda este mês!")
            }
        } else {
            $("#graficoInicio").text("Nenhuma categoria cadastrada! Por favor cadastrar ao menos uma categoria.");
        }

    })
    .catch(err => console.log(err))


// Menu
    $("#botaoMenu").on("click", (event) => {
        $("#menuEsquerdo").css({"-webkit-transform":"translate(0,0)"});
    })

    $("#btnFecharMenu").on("click", (event) => {
        $("#menuEsquerdo").css({"-webkit-transform":"translate(-100%,0)"});
    })

//Sub-menus
    $("#valorGasto").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'.', decimal:',', affixesStay: false});

    $("#formAddCategoria").on("submit", event => {
        event.preventDefault();

        let data = new FormData(event.currentTarget);
        data.set("controller", "addCategoria");

        fetch("php/controllers/home.php", {
            method: "POST",
            body: data
        })
    })

    $("#modalAddGasto").on("submit", event => {
        event.preventDefault();
        let valor = $("#valorGasto").maskMoney("unmasked");
        let categoria = $("#categoriaGasto").val();

        fetch("php/controllers/home.php", {
            method: "POST",
            body: JSON.stringify({
                controller: "addGasto",
                categoria: categoria,
                valor: valor[0]
            }),
            headers: {"Content-type": "application/json; charset=UTF-8"}
        })
    })

// Modais

function abrirModalCategorias(event) {
    const modalCategorias = new bootstrap.Modal('#modalCategorias');

    fetch("php/controllers/home.php", {
        method: "POST",
        body: JSON.stringify({
            controller: "gastosCategoria",
            categoria: event.data.id_categ
        }),
        headers: {"Content-type": "application/json; charset=UTF-8"}
    })
    .then(res => res.json())
    .then(res => {
        
        let conteudoCorpo = ""

        res.gastos.valores.forEach(elem => {
            conteudoCorpo += `Valor: ${Intl.NumberFormat("pt-BR", {style: "currency", currency: "BRL"}).format(elem.valor)} - Data: ${elem.data} <br>`
        })

        $("#cabecalhoModalCategorias").text(`Gastos de ${res.categoria.dados.nome}`);
        $("#corpoModalCategorias").html(conteudoCorpo);
    })

    $("#corpoModalCategorias").html()

    modalCategorias.show();
}

