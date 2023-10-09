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
if(document.getElementById('boardmanufcountdash'))
    makeChart('board', 'boardmanufcountdash', 'Board count', 1, 'bar');
if(document.getElementById('boardsocketcountdash'))
    makeChart('socket', 'boardsocketcountdash', 'Board count', 1, 'bar');
if(document.getElementById('boardmanufcount'))
    makeChart('board', 'boardmanufcount', 'Board count', 0.4, 'bar');
if(document.getElementById('boardsocketcount'))
    makeChart('socket', 'boardsocketcount', 'Board count', 0.4, 'bar');
if(document.getElementById('boardmanufcount'))
    makeChart('chipset', 'boardchipsetcount', 'Board count', 0.4, 'bar');
if(document.getElementById('boardsocketcount'))
    makeChart('chip', 'boardchipcount', 'Board count', 0.4, 'bar');
if(document.getElementById('boardmanufcount'))
    makeChart('ff', 'boardffcount', 'Board count', 1, 'bar');
if(document.getElementById('boardsocketcount'))
    makeChart('doc', 'chipsetdoccount', 'Board count', 2, 'pie');
async function makeChart(id, targetid, name, ratio, type) {
    const labels = JSON.parse(document.getElementById(id + 'keysId').innerHTML);
    const data = JSON.parse(document.getElementById(id + 'valuesId').innerHTML);
    new Chart(
        document.getElementById(targetid),
        {
            type: type,
            data: {
                labels: labels,
                datasets: [
                {
                    label: name,
                    backgroundColor: backgroundColor,
                    borderColor: borderColor,
                    data: data
                }
                ]
            },
            options: {
                indexAxis:'y',
                aspectRatio: ratio,
            }
        }
    );
};