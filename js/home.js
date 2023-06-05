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

        let selectCategorias = ""

        res.dadosCategoria.categorias.forEach(element => {
            categorias.push(element.nome);
            ids.push(element.id);
            cores.push(element.cor);

            selectCategorias += `<option value=${element.id}>${element.nome}</option>`
        });

        $("#categoriaGasto").append(selectCategorias);

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