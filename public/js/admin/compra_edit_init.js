webpackJsonp([13],{

/***/ 6:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "itens", function() { return itens; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "listarItens", function() { return listarItens; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "calcularTotal", function() { return calcularTotal; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "atualizarExibicao", function() { return atualizarExibicao; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "finalizarCompra", function() { return finalizarCompra; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "atualizarPedido", function() { return atualizarPedido; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "formatarErro", function() { return formatarErro; });
var moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
var itens = $('#itensPedido').data('itens'); //inicial;

var listarItens = function listarItens() {
	var lista = void 0;
	$.each(itens, function (i, item) {
		var totalItem = (parseFloat(item.preco) - parseFloat(item.desconto)) * item.qtd_entregue;
		var templateItem = '\n\t\t\t<tr>\n\t\t\t<td>' + (i + 1) + '</td>\n\t\t\t<td>' + item.product.nome + '</td>\n\t\t\t<td>' + item.qtd + '</td>\n\t\t\t<td>' + item.qtd_entregue + '</td>\n\t\t\t<td>' + item.product.unidade + '</td>\n\t\t\t<td>' + moeda.format(item.preco) + '</td>\n\t\t\t<td>' + moeda.format(item.desconto) + '</td>\n\t\t\t<td>' + moeda.format(totalItem) + '</td>\n\t\t\t<td>        \t\t\t\t\t\t\t\n\t\t\t\t<button type="button" class="btn btn-primary" title=\'Editar item\' data-toggle="modal" data-target="#modalCompraEditarItem" data-item_id="' + item.id + '">\n\t\t\t\t\t<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>\n\t\t\t\t</button>\n\t\t\t</td>\n\t\t\t</tr>\n\t\t\t';
		lista += templateItem;
	});
	var total = calcularTotal();
	var totalItens = moeda.format(total.totalItens);
	lista += '\n\t<tr>\n\t\t<td colspan="9" class="numero">\n\t\t\t<strong>Total itens: ' + totalItens + '</strong>\n\t\t</td>\n\t</tr>';
	$('#itensPedido').html(lista);
};

/**
 * calcula o total do pedido e de itens
 * @return json totalItens, total
 */
var calcularTotal = function calcularTotal() {
	var totalItens = 0;
	$.each(itens, function (i, item) {
		totalItens += (parseFloat(item.preco) - parseFloat(item.desconto)) * item.qtd_entregue; //parseFloat(item.valor_compra) * item.qtd;
	});

	var imposto = $('#imposto').val();
	var frete = $('#frete').val();
	var total = totalItens + parseFloat(imposto) + parseFloat(frete);
	return {
		totalItens: totalItens,
		total: total
	};
};

var atualizarExibicao = function atualizarExibicao() {
	var total = calcularTotal();
	listarItens();
	$("#txtCompraTotal").val(moeda.format(total.total));
};

var finalizarCompra = function finalizarCompra() {
	if (itens.length == 0) {
		$('#destaque').html('Adicione produtos ao pedido');
		return false;
	}

	var total = calcularTotal();

	$('#destaque').html("TOTAL " + moeda.format(total.total));

	bootbox.confirm({
		message: "Finalizar Compra",
		callback: function callback(confirm) {
			if (confirm) {
				atualizarPedido();
			}
		},
		onEscape: function onEscape() {
			$('.bootbox.modal').modal('hide');
			$("#modal-pagamento").focus();
		}
	});
};

var atualizarPedido = function atualizarPedido() {
	var id = $("#id").val();
	$.ajax({
		url: baseUrl + 'admin/compras/' + id,
		type: 'PUT',
		data: {
			itens: itens,
			//fornecedor_id : $('#fornecedor_id').val(),
			//user_id: $('#user_id').val(),
			frete: $('#frete').val(),
			imposto: $('#imposto').val(),
			nf: $('#nf').val(),
			obs: $('#obs').val(),
			//        	status: $('#status').val(),
			_token: _token
		},
		success: function success(data) {
			$("#destaque").html(data.msg);
			console.log(data.tarefas);
			console.log(data.msg);
			bootbox.alert(data.msg);

			location.href = data.urlConsultar; //redirecionar para pedido consultar
		},
		error: function error(jqXhr) {
			var parsedJson = jqXhr.responseJSON;
			if (jqXhr.status === 500) {
				$("#destaque").html(parsedJson.msg);
				console.error(parsedJson.tarefas);
				console.error(parsedJson.exception);
			}
			if (jqXhr.status === 422) {
				var errorString = formatarErro(parsedJson);
				$("#destaque").html(errorString);
			}
			if (jqXhr.status === 404) {
				$('#produto').html(parsedJson.msg);
			}
		}
	});
};

var formatarErro = function formatarErro(parsedJson) {
	var errorString = '';
	$.each(parsedJson.errors, function (key, value) {
		errorString += '<ul>' + key;
		$.each(value, function (i, msg) {
			errorString += '<li>' + msg + '</li>';
		});
		errorString += '</ul>';
	});
	return errorString;
};
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 62:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(63);


/***/ }),

/***/ 63:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__compra_edit__ = __webpack_require__(6);
//require("../jquery_validation");//@todo sem o validation na compilacao esta dando erro 20/09/17



$(function () {
	//console.log(items);
	__WEBPACK_IMPORTED_MODULE_0__compra_edit__["atualizarExibicao"]();

	/*
 $(document).on('keyup',function(e){
 	if(e.keyCode == 9 || e.keyCode == 27 ){//9 tab 111 / 27 esc
 		$("#cod_barra").focus().select();
 	}
 });
 
 $('form[id=formInserirProduto]').on('keyup',function(e){
 	console.log('teclacode: '+ e.keyCode);
 	console.log('teclawich: '+ e.wich);
 	if(e.keyCode == 111){//111 /
 //		$("#cod_barra").focus().select();
 	}
 	
 	if(e.keyCode == 106){//106 * / 42
 	//	$("#qtd").focus().select();
 	}
 	
 	if(e.keyCode == 187){// 187 = 
 		pedido.finalizarCompra();
 	}
 	
 	if(e.keyCode == 109){//109 - 
 		$( "#btExcluirItem" ).trigger("click");
 	}
 	
 	
 });
    */

	$('#imposto, #frete').on('blur', function () {
		__WEBPACK_IMPORTED_MODULE_0__compra_edit__["atualizarExibicao"]();
	});

	$('#btFinalizarCompra').on('click', function () {
		__WEBPACK_IMPORTED_MODULE_0__compra_edit__["finalizarCompra"]();
	});

	$("#form_compra").submit(function (e) {
		e.preventDefault();
		console.log(' submit em form compra');
	});
	/*
     $("form[name=form]").validate({
         rules: {
             cod_barra:{
                 required: true,
                 number: true
             },
             qtd:{number:true,
             	required:true,
             	min:1
             }            
         },
         messages: {}
     });
     */
});
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ })

},[62]);