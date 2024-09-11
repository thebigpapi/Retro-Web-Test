import Chart from 'chart.js/auto';
const borderColor = [
    'rgb(255, 99, 132)',
    'rgb(255, 159, 64)',
    'rgb(255, 205, 86)',
    'rgb(75, 192, 192)',
    'rgb(54, 162, 235)',
    'rgb(153, 102, 255)',
    'rgb(201, 203, 207)'
];
const backgroundColor = [
    'rgba(255, 99, 132, 0.9)',
    'rgba(255, 159, 64, 0.9)',
    'rgba(255, 205, 86, 0.9)',
    'rgba(75, 192, 192, 0.9)',
    'rgba(54, 162, 235, 0.9)',
    'rgba(153, 102, 255, 0.9)',
    'rgba(201, 203, 207, 0.9)'
];
let statCharts = document.getElementsByClassName("statistics-charts")
if(statCharts[0]){
    for (let chart of statCharts[0].children) {
        makeChart(chart, false);
    }
}

let statChartsSize = document.getElementsByClassName("statistics-charts-size");
if(statChartsSize[0]){
    for (let chart of statChartsSize[0].children) {
        makeChart(chart, true);
    }
}
async function makeChart(chart, sizeChart) {
    const id = chart.getAttribute("data-id");
    new Chart(
        document.getElementById(id + "Canvas"),
        {
            type: chart.getAttribute("data-type"),
            data: {
                labels: JSON.parse(document.getElementById(id + 'keysId').innerHTML),
                datasets: [{
                    label: chart.getAttribute("data-name"),
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    data: JSON.parse(document.getElementById(id + 'valuesId').innerHTML)
                }]
            },
            options: {
                indexAxis:'y',
                aspectRatio: chart.getAttribute("data-ratio"),
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if(!sizeChart)
                                    return context.dataset.label + ": " + context.formattedValue;
                                let label = context.label || '';
                                let size = context.raw || 0;
                                let unit = "Bytes";
                                if (size > 1024){
                                    size /= 1024;
                                    unit = "KiB";
                                }
                                if (size > 1024){
                                    size /= 1024;
                                    unit = "MiB";
                                }
                                if (size > 1024){
                                    size /= 1024;
                                    unit = "GiB";
                                }
                                label += ": " + Math.floor(size * 100) /100 + " " + unit;
                                return label;
                            }
                        }
                    }
                }
            }
        }
    );
};