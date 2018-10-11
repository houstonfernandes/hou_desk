webpackJsonp([12],{

/***/ 145:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(146);


/***/ }),

/***/ 146:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {$(function () {

	$.each(equipamentos, function (i, e) {
		locais.push(e.local_nome);
		quantidades.push(parseInt(e.quantidade));
		cores.push(getRandomColor());
		dados.push({
			label: e.local_nome,
			data: [e.local_nome, parseInt(e.quantidade)],
			backgroundColor: getRandomColor()
		});
	});

	console.log(locais);
	console.log(quantidades);
	console.log(dados);

	try {
		if (equipamentos.length == 0) {
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
					position: 'right',
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

		var myChart = new Chart(canvas2, {
			type: 'bar',
			data: {
				labels: locais,
				datasets: dados
			},
			options: {
				title: {
					display: true,
					text: 'Quantidade de equipamentos'
				},
				tooltips: {
					enabled: true
				},

				legend: {
					display: true,
					position: 'bottom'
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							stepSize: 1
						}
					}],
					xAxes: [{
						display: false,
						ticks: {
							//beginAtZero: true,
							//stepSize: 1
						}
					}]

				}
			}
		});
	} catch (e) {
		console.log(e);
	}
});

var locais = [];
var quantidades = [];
var cores = [];
var dados = [];

var canvas = document.getElementById("chart");
var canvas2 = document.getElementById("chart2");
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ })

},[145]);