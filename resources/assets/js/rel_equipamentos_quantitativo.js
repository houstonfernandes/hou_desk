$(function(){
	$.each(equipamentos, function(i,e){
		locais.push(e.local_nome);
	    quantidades.push(parseInt(e.quantidade));
	    cores.push(getRandomColor());
	});
	
	try{
		    if(equipamentos.length == 0){
		        throw "sem registros";
		    }

		    var myChart = new Chart(canvas, {
		        type: 'bar',
		        data: {
		            labels: locais,
		            datasets: [{
		                label: 'quantidades', //'Documentos Registrados',
		                data: quantidades, 
		                backgroundColor: cores
		            }]
		        },
		        options: {
		        	title: {
		                display: true,
		                text: 'Quantidade de equipamentos'
		            },
		            legend: {
		                display: false,
		                labels: {
		                    fontColor: 'red'
		                }
		            },
		            scales: {
		                yAxes: [{
		                    ticks: {
		                        beginAtZero: true,
		                        stepSize: 1
		                    }
		                }]
		            }
		        }
		    });
		}catch(e){
		    console.log(e);
		}
});

let locais = [];
let quantidades = [];
let cores = [];
let canvas = document.getElementById("chart");

window.getRandomColor = function() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
