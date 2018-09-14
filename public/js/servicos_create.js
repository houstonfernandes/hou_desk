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
	$('#setor_id').on('change', function () {
		var setor_id = $(this).val();
		if (setor_id == '') {
			$('#equipamento_id').empty();
			return false;
		}
		//buscar equipamentos
		$.ajax({
			url: baseUrl + 'api/equipamentos/listar_setor/' + setor_id, //urlPesquisarProduto,
			type: 'GET',
			data: {
				//	        	_token: _token
			},
			success: function success(data) {
				console.log(data.msg);
				$('#equipamento_id').empty();
				var $option = $('<option>').prop({
					'value': '', 'selected': 'selected'
				}).html('Selecione um equipamento');
				$('#equipamento_id').append($option);
				$.each(data.equipamentos, function (i, equipamento) {
					var texto = equipamento.nome;
					texto += equipamento.descricao != null ? ' - ' + equipamento.descricao : ' ';
					texto += equipamento.num_etiqueta != null ? ' - ' + equipamento.num_etiqueta : ' ';

					var $option = $('<option>').prop({
						'value': equipamento.id
					}).html(texto);
					$('#equipamento_id').append($option);
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
					$('#equipamento_id').html($option);
					//$('#divMsg').html(parsedJson.msg);
				}
			}
		});
	});
});
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