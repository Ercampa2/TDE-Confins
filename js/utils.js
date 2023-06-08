function definirGrafico(elementId, options) {
    let grafico = $(`#${elementId}`)[0];
    let myChart = echarts.init(grafico);
    options && myChart.setOption(options);
}