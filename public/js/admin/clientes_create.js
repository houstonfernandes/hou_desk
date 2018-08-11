webpackJsonp([27],{

/***/ 27:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(28);


/***/ }),

/***/ 28:
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {
$("form[name=form]").validate({
    rules: {
        nome: { required: true, minlength: 3, maxlength: 80 },
        email: { email: true },
        cpf: { required: true, verificaCPF: true }
    }
});

$('#cpf').mask('###.#####-####'); //pessoa fisica inicial
$('#nome_fantasia').prop("disabled", true);

// -------------MASCARA EM CAMPOS
$("#cpf").mask("###.###.###-##").focus(); //inicia mask cpf
$("#cep").mask("#####-###");

$('#tipo_cliente_juridica').click( //quando ativar cnpj
function () {
    $("#cpf").mask("##.###.###-####/##").focus();
    $('#nome_fantasia').prop("disabled", false);
});
$('#tipo_cliente_fisica').click( //quando ativar cpf
function () {
    $("#cpf").mask("###.###.###-##").focus();
    $('#nome_fantasia').prop("disabled", true);
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(0)))

/***/ })

},[27]);