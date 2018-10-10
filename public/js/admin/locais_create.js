webpackJsonp([19],{

/***/ 153:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(154);


/***/ }),

/***/ 154:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {
$("form[name=form]").validate({
    rules: {
        nome: { required: true, minlength: 3, maxlength: 80 },
        email: { email: true },
        cnpj: { required: true, verificaCPF: true }
    }
});
// -------------MASCARA EM CAMPOS
$("#cnpj").mask("##.###.###-####/##").focus();
//	$("#cpf").mask("###.###.###-##").focus();//inicia mask cpf
$("#cep").mask("#####-###");
//$('#cpf').mask('###.#####-####');//pessoa fisica inicial
//$('#nome_fantasia').prop("disabled", true);


/*	
$('#tipo_fornecedor_juridica').click(//quando ativar cnpj
    function(){
        $("#cnpj").mask("##.###.###-####/##").focus();
        $('#nome_fantasia').prop("disabled", false);
    }
);
$('#tipo_fornecedor_fisica').click(//quando ativar cpf
    function(){
    	$("#cpf").mask("###.###.###-##").focus();
    	$('#nome_fantasia').prop("disabled", true);
    }
);
*/
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ })

},[153]);