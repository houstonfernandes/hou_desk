$(function(){	
	$.each(servicos, function(i,e){
		locais.push(e.local_nome);
	    quantidades.push(parseInt(e.quantidade));
	    cores.push(getRandomColor());
	    dados.push(
	    		{
	    			label: e.local_nome,
	    			data:  [e.local_nome, parseInt(e.quantidade)],
	    			backgroundColor: getRandomColor()
	    		}
	    );
	});
	
console.log(locais);
console.log(quantidades);
console.log(dados);
	
	try{
		    if(servicos.length == 0){
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
		                text: 'Quantidade de servicos'
		            },
		            legend: {
		                display: false,
		                position: 'right',
		                labels: {
		                    fontColor: 'red',		                    
		                }
		            },
		            scales: {
		                yAxes: [{
		                    ticks: {
		                        beginAtZero: true,
		                        stepSize: 1
		                    }
		                }],		                
		            }
		        }
		    });
		    
		    
		    var myChart = new Chart(canvas2, {
		        type: 'bar',
		        data: {
		            labels: locais,
		            datasets: dados		            
		        },
		        options: {
		        	title: {
		                display: true,
		                text: 'Quantidade de serviços'
		            },		        	
		        	tooltips: {
		        		enabled:true
		        	},
		        	
		            legend: {
		                display: true,
		                position: 'bottom',
		            },
		            scales: {
		                yAxes: [{
		                    ticks: {
		                        beginAtZero: true,
		                        stepSize: 1
		                    }
		                }],
		                xAxes: [{
		                	display:false,
		                    ticks: {
		                        //beginAtZero: true,
		                        //stepSize: 1
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
let dados = [];

let canvas = document.getElementById("chart");
let canvas2 = document.getElementById("chart2");
