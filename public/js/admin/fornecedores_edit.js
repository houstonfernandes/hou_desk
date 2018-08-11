webpackJsonp([22],{

/***/ 37:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(38);


/***/ }),

/***/ 38:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {$("form[name=form]").validate({
	rules: {
		nome: { required: true, minlength: 3, maxlength: 80 },
		email: { email: true }
	}
});

//$('#cpf').mask('###.#####-####');


// -------------MASCARA EM CAMPOS
$("#cep").mask("#####-###");

var tipoFornecedor = $('#tipo_fornecedor').val();

switch (tipoFornecedor) {
	case '0':
		//$("#cpf").mask("###.###.###-##");
		$('#nome_fantasia').prop("disabled", true);
		break;
	case '1':
		//    $("#cpf").mask("##.###.###-####/##");
		$('#nome_fantasia').prop("disabled", false);
		break;
}
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ })

},[37]);