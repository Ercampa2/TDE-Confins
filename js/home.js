// dados iniciais
atualizarDados();
atualizarNoticias();

var colSettings = [
    { 
        data: "valor",
        // width: "80%"
    },
    {
        data: "data",
        _: "dataDesformatada",
        // width: "80%"
    },
    {
        data: "btnEditar",
        orderable: false,
    },
    {
        data: "btnExcluir",
        orderable: false,
    }
]

var tabelaGastos = $("#tabelaGastos").DataTable({
    lengthChange: false,
    pageLength: 25,
    lengthMenu: -1,
    order: [[0, "asc"]],
    columns: colSettings,
    language: {
        info: "Mostrando _START_ a _END_ de um total de _TOTAL_"
    }
})

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
        .then(() => atualizarDados())
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
        .then(() => atualizarDados());
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
            tabelaGastos.row.add({
                "valor": formatarReal(elem.valor),
                "data": formatarData(new Date(elem.data)),
                "dataDesformatada": elem.data,
                "btnEditar": `<button class="btn btn-primary-custom"><i class="bi bi-pencil"></i></button>`,
                "btnExcluir": `<button class="btn btn-primary-custom"><i class="bi bi-trash"></i></button>`
            });
            conteudoCorpo += `Valor: ${Intl.NumberFormat("pt-BR", {style: "currency", currency: "BRL"}).format(elem.valor)} - Data: ${elem.data} <br>`
        })
        tabelaGastos.draw();

        $("#cabecalhoModalCategorias").text(`Gastos de ${res.categoria.dados.nome}`);
        // $("#corpoModalCategorias").html(conteudoCorpo);
    })

    $("#corpoModalCategorias").html()

    modalCategorias.show();
}

function atualizarDados() {
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
                let cores = [];

                res.dadosGrafico.valores.forEach(element => {
                    dados.push({
                        value: element.valor,
                        name: element.categoria,
                        id_categ: element.id_categoria,
                    });

                    cores.push(element.cor);
                })
                
                let option = {
                    title: {
                        text: 'Gastos do mês por categoria',
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
                $("#graficoInicio").text("Nenhum valor gasto ainda este m�s!")
            }
        } else {
            $("#graficoInicio").text("Nenhuma categoria cadastrada! Por favor cadastrar ao menos uma categoria.");
        }

    })
    .catch(err => console.log(err))
}

function atualizarNoticias() {
    // Dólar
    fetch("https://brapi.dev/api/v2/currency?currency=USD-BRL")
    .then(res => res.json())
    .then(res => $("#valorDolar").text(formatarReal(res.currency[0].bidPrice)))

    //Euro
    fetch("https://brapi.dev/api/v2/currency?currency=EUR-BRL")
    .then(res => res.json())
    .then(res => $("#valorEuro").text(formatarReal(res.currency[0].bidPrice)))
    
    // Selic
    
    let data = formatarData(new Date());
    let dataEncoded = encodeURIComponent(data);
    
    fetch(`https://brapi.dev/api/v2/prime-rate?country=brazil&historical=false&start=${dataEncoded}&end=${dataEncoded}&sortBy=date&sortOrder=desc`)
    .then(res => res.json())
    .then(res => $("#valorSelic").text(`${res["prime-rate"][0].value} %`));
    
    //BTC
    fetch("https://brapi.dev/api/v2/crypto?coin=BTC&currency=BRL")
    .then(res => res.json())
    .then(res => $("#valorBtc").text(formatarReal(res.coins[0].regularMarketPrice)))
    
    //ETH
    fetch("https://brapi.dev/api/v2/crypto?coin=ETH&currency=BRL")
    .then(res => res.json())
    .then(res => $("#valorEth").text(formatarReal(res.coins[0].regularMarketPrice)))
    
    //USDT
    fetch("https://brapi.dev/api/v2/crypto?coin=USDT&currency=BRL")
    .then(res => res.json())
    .then(res => $("#valorUsdt").text(formatarReal(res.coins[0].regularMarketPrice)))

}