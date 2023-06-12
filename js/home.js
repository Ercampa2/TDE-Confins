// dados iniciais
atualizarDados();
atualizarNoticias();
atualizarGraficosMeses(); 

var colSettings = [
    { 
        data: "valor",
        _: "valorDesformatado"
    },
    {
        data: "data",
        _: "dataDesformatada",
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
        info: "Mostrando _START_ a _END_ gastos de _TOTAL_ totais",
        infoFiltered: "(Filtrado de um total de _MAX_ gastos)",
        paginate: {
            previous: "Anterior",
            next: "Pr&oacute;xima",
        },
        search: "Buscar:",
    }
})

var tabelaReceitas = $("#tabelaReceitas").DataTable({
    lengthChange: false,
    pageLength: 25,
    lengthMenu: -1,
    order: [[0, "asc"]],
    columns: colSettings,
    language: {
        info: "Mostrando _START_ a _END_ receitas de _TOTAL_ totais",
        infoFiltered: "(Filtrado de um total de _MAX_ gastos)",
        paginate: {
            previous: "Anterior",
            next: "Pr&oacute;xima",
        },
        search: "Buscar:",
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
    $("#valorEntrada").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'.', decimal:',', affixesStay: false});
    $("#valorEdicaoGastos").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'.', decimal:',', affixesStay: false});
    $("#valorEdicaoReceita").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'.', decimal:',', affixesStay: false});

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
        .then(() => atualizarDados())
        .then(() => atualizarGraficosMeses())
        .then(() => $("#modalAddGasto").modal("hide"));
    })

    $("#formAddEntrada").on("submit", event => {
        event.preventDefault();
        let valor = $("#valorEntrada").maskMoney("unmasked");

        fetch("php/controllers/home.php", {
            method: "POST",
            body: JSON.stringify({
                controller: "addEntrada",
                valor: valor[0]
            }),
            headers: {"Content-type": "application/json; charset=UTF-8"}
        })
        .then(() => atualizarDados())
        .then(() => atualizarGraficosMeses())
        .then(() => $("#modalAddReceitas").modal("hide"));
    })


// Modais
    $("#modalEditarGasto").on("show.bs.modal", e => {
        const button = e.relatedTarget;
        const id = button.getAttribute('data-id');

        fetch("php/controllers/home.php", {
            method: "POST",
            body: JSON.stringify({
                controller: "editarGasto",
                id: id
            }),
            headers: {"Content-type": "application/json; charset=UTF-8"}
        })
        .then(res => res.json())
        .then(res => {

            // Colocar as categorias no elemento select
            let selectCategorias = "";
            res.categorias.categorias.forEach(elem => {
                selectCategorias += `<option value="${elem.id}">${elem.nome}</option>`;
            })
            $("#categoriaEdicaoGastos").html(selectCategorias);

            // Selecionar a categorias do gasto e seu valor
            $("#categoriaEdicaoGastos").val(res.categoriaGasto.dados.id);
            $("#valorEdicaoGastos").val(res.gasto.valor);
            $("#idEdicaoGastos").val(res.gasto.id);
        })
    })

    $("#modalEditarReceita").on("show.bs.modal", e => {
        const button = e.relatedTarget;
        const id = button.getAttribute('data-id');

        fetch("php/controllers/home.php", {
            method: "POST",
            body: JSON.stringify({
                controller: "editarReceita",
                id: id
            }),
            headers: {"Content-type": "application/json; charset=UTF-8"}
        })
        .then(res => res.json())
        .then(res => {

            // Selecionar a categorias do gasto e seu valor
            $("#valorEdicaoReceita").val(res.receita.valor);
            $("#idEdicaoReceita").val(res.receita.id);
        })
    })

    $("#modalEditarCategoria").on("show.bs.modal", e => {
        fetch("php/controllers/home.php", {
            method: "POST",
            body: JSON.stringify({
                controller: "categoriasEdicao",
            }),
            headers: {"Content-type": "application/json; charset=UTF-8"}
        })
        .then(res => res.json())
        .then(res => {
            let selectCategorias = "<option selected disabled> --Selecione uma categoria-- </option>"
            res.categorias.forEach(elem => {
                selectCategorias += `<option value="${elem.id}">${elem.nome}</option>`;
            })
            $("#categoriasEdicao").html(selectCategorias);
        })
    })

    $("#categoriasEdicao").on("change", e=> {
        fetch("php/controllers/home.php", {
            method: "POST",
            body: JSON.stringify({
                controller: "dadosCategoria",
                categoria: e.target.value
            }),
            headers: {"Content-type": "application/json; charset=UTF-8"}
        })
        .then(res => res.json())
        .then(res => {
            $("#editarCor").val(res.dados.cor)
            $("#editarNome").val(res.dados.nome)
        })
    })

    $("#modalReceitas").on("show.bs.modal", e => {
        fetch("php/controllers/home.php", {
            method: "POST",
            body: JSON.stringify({
                controller: "listargemReceitas",
            }),
            headers: {"Content-type": "application/json; charset=UTF-8"}
        })
        .then(res => res.json())
        .then(res => {
            
            tabelaReceitas.rows().remove();
            res.valores.forEach(elem => {
                tabelaReceitas.row.add({
                    "valor": formatarReal(elem.valor),
                    "data": formatarData(new Date(elem.data)),
                    "btnEditar": `<button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalEditarReceita" data-id="${elem.id}"><i class="bi bi-pencil"></i></button>`,
                    "btnExcluir": `<button class="btn btn-primary-custom" onclick="excluirReceita(${elem.id})"><i class="bi bi-trash"></i></button>`,
                    valorDesformatado: elem.valor,
                    dataDesformatada: elem.data,
                });
            })
            tabelaReceitas.draw();
    
        })
    })


// Dados
    $("#editarGasto").on("submit", e => {
        e.preventDefault();

        let data = new FormData(e.currentTarget);
        data.set("controller", "editarValoresGasto");
        data.set("valor", $("#valorEdicaoGastos").maskMoney("unmasked")[0]);

        fetch("php/controllers/home.php", {
            method: "POST",
            body: data
        })
        .then(() => atualizarDados())
        .then(() => atualizarGraficosMeses())
        .then(() => $("#modalEditarGasto").modal("hide"))
    })
    
    $("#editarReceita").on("submit", e => {
        e.preventDefault();

        let data = new FormData(e.currentTarget);
        data.set("controller", "editarValorReceita");
        data.set("valor", $("#valorEdicaoReceita").maskMoney("unmasked")[0]);

        fetch("php/controllers/home.php", {
            method: "POST",
            body: data
        })
        .then(() => atualizarDados())
        .then(() => atualizarGraficosMeses())
        .then(() => $("#modalEditarReceita").modal("hide"))
    })

    $("#editcaoCategoria").on("submit", e => {
        e.preventDefault();

        let data = new FormData(e.currentTarget);
        data.set("controller", "editarCategoria");

        fetch("php/controllers/home.php", {
            method: "POST",
            body: data
        })
        .then(() => atualizarDados())
        .then(() => $("#modalEditarCategoria").modal("hide"))
    })

function excluirGasto(id) {
    fetch("php/controllers/home.php", {
        method: "POST",
        body: JSON.stringify({
            controller: "excluirGasto",
            id: id
        }),
        headers: {"Content-type": "application/json; charset=UTF-8"}
    })
}

function excluirReceita(id) {
    fetch("php/controllers/home.php", {
        method: "POST",
        body: JSON.stringify({
            controller: "excluirReceita",
            id: id
        }),
        headers: {"Content-type": "application/json; charset=UTF-8"}
    })

    $("#modalReceitas").modal("hide")
}

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
        
        tabelaGastos.rows().remove();
        res.gastos.valores.forEach(elem => {
            console.log(elem.valor);
            tabelaGastos.row.add({
                "valor": formatarReal(elem.valor),
                "data": formatarData(new Date(elem.data)),
                "btnEditar": `<button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalEditarGasto" data-id="${elem.id}"><i class="bi bi-pencil"></i></button>`,
                "btnExcluir": `<button class="btn btn-primary-custom" onclick="excluirGasto(${elem.id})"><i class="bi bi-trash"></i></button>`,
                valorDesformatado: elem.valor,
                dataDesformatada: elem.data,
            });
        })
        tabelaGastos.draw();

        $("#cabecalhoModalCategorias").html(`Gastos de ${res.categoria.dados.nome} <span class="dot" style="background-color: ${res.categoria.dados.cor}; "></span>`);
    })

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
                        trigger: 'item',
                        formatter: function(params) {
                            let res = `<div>Gasto da categoria</div>`;
                            res += `<div style="margin: 0px 0 0;line-height:1;"><span style="display:inline-block;margin-right:4px;border-radius:10px;width:10px;height:10px;background-color:${params.color};"></span><span style="font-size:14px;color:#666;font-weight:400;margin-left:2px">${params.data.name}</span><span style="float:right;margin-left:20px;font-size:14px;color:#666;font-weight:900">${formatarReal(params.data.value)}</span><div style="clear:both"></div></div>`;
                            return res;
                        }
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

function atualizarGraficosMeses() {
    fetch("php/controllers/home.php", {
        method: "POST",
        body: JSON.stringify({
            controller: "graficoMeses"
        }),
        headers: {"Content-type": "application/json; charset=UTF-8"}
    })
    .then(res => res.json())
    .then(res => {
        let valor = [];
        let valorEntrada = [];
        let data = [];
        let dataEntrada = [];
        res.dados.forEach(elem => {
            valor.push(elem.valor);
            data.push(elem.data);
        })

        res.dados2.forEach(elem => {
            valorEntrada.push(elem.valor);
            dataEntrada.push(elem.data);
        })

        let option = {
            title: {
                text: 'Gastos dos ultimos 6 meses',
                left: 'center',
                textStyle: {
                    color: "#292f2e"
                }
            },
            xAxis: {
                type: 'category',
                data: data,
                axisLabel: {
                    color: "#292f2e",
                },
                
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    color: "#292f2e",
                    formatter: value => formatarReal(value)
                },
                name: "Valor",
                nameTextStyle: {
                    color: "#292f2e"
                }
            },
            tooltip: {
                trigger: 'item',
                formatter: function(params) {
                    let res = `<div>Gasto do mes</div>`;
                    res += `<div style="margin: 0px 0 0;line-height:1;"><span style="display:inline-block;margin-right:4px;border-radius:10px;width:10px;height:10px;background-color:${params.color};"></span><span style="font-size:14px;color:#666;font-weight:400;margin-left:2px">${params.seriesName}</span><span style="float:right;margin-left:20px;font-size:14px;color:#666;font-weight:900">${formatarReal(params.data)}</span><div style="clear:both"></div></div>`;
                    return res;
                }
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
                    name: "Valor",
                    type: "bar",
                    data: valor,
                    label: {
                        color: "#292f2e"
                    },
                }
            ],
            color: "#ff6666"
        };

        definirGrafico("graficoMesesSaida", option);

        let option2 = {
            title: {
                text: 'Receitas dos ultimos 6 meses',
                left: 'center',
                textStyle: {
                    color: "#292f2e"
                }
            },
            xAxis: {
                type: 'category',
                data: dataEntrada,
                axisLabel: {
                    color: "#292f2e",
                },
                
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    color: "#292f2e",
                    formatter: value => formatarReal(value)
                },
                name: "Valor",
                nameTextStyle: {
                    color: "#292f2e"
                }
            },
            tooltip: {
                trigger: 'item',
                formatter: function(params) {
                    let res = `<div>Receitas do mes</div>`;
                    res += `<div style="margin: 0px 0 0;line-height:1;"><span style="display:inline-block;margin-right:4px;border-radius:10px;width:10px;height:10px;background-color:${params.color};"></span><span style="font-size:14px;color:#666;font-weight:400;margin-left:2px">${params.seriesName}</span><span style="float:right;margin-left:20px;font-size:14px;color:#666;font-weight:900">${formatarReal(params.data)}</span><div style="clear:both"></div></div>`;
                    return res;
                }
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
                    name: "Valor",
                    type: "bar",
                    data: valorEntrada,
                    label: {
                        color: "#292f2e"
                    },
                }
            ],
            color: "#008040"
        };

        definirGrafico("graficoMesesEntrada", option2);
    });
}