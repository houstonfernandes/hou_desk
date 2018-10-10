webpackJsonp([5],{

/***/ 141:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(142);
__webpack_require__(143);
module.exports = __webpack_require__(144);


/***/ }),

/***/ 142:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {$(function () {
	local_id = $('#local_id').val();

	if (local_id != '') {
		listarSetores();
	}

	$('#local_id').on('change', function () {
		local_id = $(this).val();
		if (local_id == '') {
			limparSetores();
			return false;
		}
		listarSetores();
	});
	//console.log(equipamentos);


	$.each(equipamentos, function (i, e) {
		locais.push(e.local_nome);
		quantidades.push(parseInt(e.quantidade));
		cores.push(getRandomColor());
	});

	try {
		/*
   
       if(origem_id == "*"){
          throw "origem nao definida!!";
      }
      
      */

		if (equipamentos.length == 0) {
			throw "sem registros";
		}

		var myChart = new Chart(canvas, {
			type: 'bar',
			data: {
				labels: locais,
				datasets: [{
					label: 'quantidade', //'Documentos Registrados',
					data: quantidades,
					backgroundColor: cores
				}]
			},
			options: {
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
	} catch (e) {
		console.log(e);
	}
});

var locais = [];
var quantidades = [];
var cores = [];
var canvas = document.getElementById("chart");

var local_id = void 0;
var limparSetores = function limparSetores() {
	$('#setor_id').empty();
};

var listarSetores = function listarSetores() {
	//buscar locais e montar options
	$.ajax({
		url: baseUrl + 'api/locais/listar_setores/' + local_id,
		type: 'GET',
		data: {
			//	        	_token: _token
		},
		success: function success(data) {
			console.log(data.msg);
			$('#setor_id').empty();
			var $option = $('<option>').prop({
				'value': '', 'selected': 'selected'
			}).html('todos');
			$('#setor_id').append($option);
			var selected = $('#setor_id_value').val();
			$.each(data.setores, function (i, setor) {
				var texto = setor.nome;
				var $option = $('<option>').prop({
					'value': setor.id
				});
				if (selected == setor.id) {
					$option.prop('selected', 'selected');
				}
				$option.html(texto);
				$('#setor_id').append($option);
			});
		},
		error: function error(jqXhr) {
			var parsedJson = jqXhr.responseJSON;
			if (jqXhr.status === 500) {
				$('#divMsg').html(parsedJson.msg);
			}
			if (jqXhr.status === 404) {
				var $option = $('<option>').prop({
					'value': ''
				}).html(parsedJson.msg);
				$('#setor_id').html($option);
				//$('#divMsg').html(parsedJson.msg);
			}
		}
	});
};

window.getRandomColor = function () {
	var letters = '0123456789ABCDEF'.split('');
	var color = '#';
	for (var i = 0; i < 6; i++) {
		color += letters[Math.floor(Math.random() * 16)];
	}
	return color;
};
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ }),

/***/ 143:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 144:
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })

},[141]);