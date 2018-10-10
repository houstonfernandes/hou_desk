webpackJsonp([10],{

/***/ 145:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(146);


/***/ }),

/***/ 146:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {$(function () {
	var situacao = void 0;
	$('[name=situacao], [name=solucao]').on('focus', function () {
		$("#erro_atender").empty();
	});

	$('[name=situacao]').on('change', function () {
		situacao = $(this).val();
		if (situacao == '') {
			$('[name=solucao]').val('');
			return false;
		}
	});

	$('form[name=form_atendimento]').on('submit', function (e) {
		if ($('[name=situacao]').val() == 5) {
			var solucao = $('[name=solucao]').val();
			console.log(solucao);
			if (solucao.length < 5) {
				var msg = 'Campo solução deve ser informado, com mais de 5 caracteres.';
				var msgString = '<div role="alert" class="alert alert-danger">\n\t\t\t\t\t\t\t\t\t<button type="button" class="close" data-dismiss="alert" aria-hidden="true">\n\t\t\t\t\t\t\t\t\t\t&times;\n\t\t\t\t\t\t\t\t\t</button>\n\t\t\t\t\t\t\t\t\t' + msg + '\n\t\t\t\t\t\t\t\t</div>';

				$("#erro_atender").html(msgString);
				e.preventDefault();
			}
		}
	});
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ })

},[145]);