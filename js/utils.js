function definirGrafico(elementId, options) {
    let grafico = $(`#${elementId}`)[0];
    let myChart = echarts.init(grafico);
    options && myChart.setOption(options);
}

function formatarReal(valor) {
    return Intl.NumberFormat("pt-BR", {style: "currency", currency: "BRL"}).format(valor);
}

function formatarData(date) {
    return Intl.DateTimeFormat("pt-br", {dateStyle: "short"}).format(date); 
} 

function subtrairMes(data, qtd) {
    const copia = new Date(data);
    copia.setMonth(copia.getMonth() - qtd);
    return copia;
}