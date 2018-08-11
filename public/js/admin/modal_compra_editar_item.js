webpackJsonp([12],{

/***/ 59:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(60);


/***/ }),

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

/***/ 60:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__compra_edit__ = __webpack_require__(6);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };


//let imagemInicial = $("#imagemProduto").prop('src');
var moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
var $linha = $('<tr>');
var $coluna = $('<td>');
var produtoPesquisaSelecionado = void 0;
var urlPesquisaProduto = void 0; //@todo pegar do botao
var path = baseUrl + 'product_images/';
var semImagem = 'sem_imagem.jpg';
var indiceEditar = void 0;
var itemEditar = void 0;
var atualizarDadosModal = function atualizarDadosModal(id) {
	try {
		var item = procurarItem(id);
		itemEditar = item;
		console.log(itemEditar);
		if (!item) throw "Item não encontrado";
		$('#txtCompraEditarItemCodBarra').val(item.product.cod_barra);
		$('#txtCompraEditarItemNome').val(item.product.nome);
		$('#txtCompraEditarItemQtd').val(item.qtd);
		$('#txtCompraEditarItemUnidade').val(item.product.unidade);
		var imageName = void 0;
		if (item.product.images.length > 0) {
			imageName = item.product.images[0].id + '.' + item.product.images[0].extension;
		} else {
			imageName = semImagem;
		}
		//console.log(`image name: ${path + imageName}`);
		$('#imgCompraProdutoPesquisaImagem').prop('src', path + imageName);
		$('#txtCompraEditarItemQtdEntregue').val(item.qtd_entregue);
		$('#txtCompraEditarItemPreco').val(item.preco);
		$('#txtCompraEditarItemDesconto').val(item.desconto);
		$('#txtCompraEditarItemObs').val(item.obs);
	} catch (e) {
		//@todo escrever falha no modal e fechar	

		console.log(e);
	}
};

var procurarItem = function procurarItem(id) {
	var saida = null;
	$.each(__WEBPACK_IMPORTED_MODULE_0__compra_edit__["itens"], function (i, item) {
		if (item.id == id) {
			saida = _extends({}, item); //copia do objeto
			indiceEditar = i;
			return false; //sair do each
		}
	});
	return saida;
};

/**
 * Consulta o produto pela API
 */
var consultarProduto = function consultarProduto(id) {
	console.log('consultando ajax');
	//produto = null;
	$.ajax({
		url: baseUrl + 'api/products/consultar/' + id, //urlPesquisarProduto,
		type: 'get',
		success: function success(data) {
			console.log(data.produto.nome);
		},
		error: function error(jqXhr) {
			var parsedJson = jqXhr.responseJSON;
			if (jqXhr.status === 500) {
				//            	$('#divMsgPesquisa').html(parsedJson.msg);
				console.log('erro 500');
			}
			if (jqXhr.status === 404) {
				//          	$('#divMsgPesquisa').html(parsedJson.msg);
				console.log('erro 404');
			}
		}
	});
};

$('#modalCompraEditarItem').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget); // Button that triggered the modal
	var id = button.data('item_id'); // Extract info from data-* attributes
	atualizarDadosModal(id); //itemEditar);
});

$("#formCompraItemEditar").submit(function (e) {
	e.preventDefault();
	//itens[indiceEditar] = itemEditar;
	//atribuir valores a 

	itemEditar.qtd_entregue = $("#txtCompraEditarItemQtdEntregue").val();
	itemEditar.preco = $("#txtCompraEditarItemPreco").val();
	itemEditar.desconto = $("#txtCompraEditarItemDesconto").val();
	itemEditar.obs = $("#txtCompraEditarItemObs").val();
	__WEBPACK_IMPORTED_MODULE_0__compra_edit__["itens"][indiceEditar] = itemEditar;
	console.log(itemEditar);
	Object(__WEBPACK_IMPORTED_MODULE_0__compra_edit__["atualizarExibicao"])();
	$('#modalCompraEditarItem').modal('hide');
});

/*
$('#modalCompraPesquisarProduto').on('keyup', function (e) {
	if(e.keyCode == 106 || e.keyCode == 109){//42 * ou 109 -
		$("#txtCompraProdutoPesquisaCodBarra").focus();
	}
});

*/

/*
$('#modalCompraEditarItem').on('hide.bs.modal', function (e) {
	retornaFoco();		
}).on('hidden.bs.modal', function (e) {
	retornaFoco();
});

export let limparListaPesquisa = function(){
	$('#tbCompraProdutoItensPesquisa').empty();
	$('#divCompraProdutoPesquisaMsg').empty();
	$('#imgCompraProdutoPesquisaImagem').prop('src', imagemInicial);
};

export let atualizarListaPesquisa = function(produtos){	
	limparListaPesquisa();
    $.each( produtos, function( i, item) {
    	let linhaItem = $linha.clone();
    	let c0 = $coluna.clone().html(i+1);
    	let c1 = $coluna.clone().html(item.nome);
    	let c2 = $coluna.clone().html(item.unidade);
    	let c3 = $coluna.clone().html(moeda.format(item.preco));
    	linhaItem.append([c0, c1, c2, c3]).data('produto',item).on('click', function(){
    		exibirProdutoPesquisa($(this).data('produto'));
    		produtoPesquisaSelecionado = $(this).data('produto');
    	});
    	$('#tbCompraProdutoItensPesquisa').append(linhaItem);    	
    });
    if(produtos.length==1){
    	exibirProdutoPesquisa(produtos[0]);//somente um, exibe
    	produtoPesquisaSelecionado = produtos[0];
    }
//    $('#divCompraProdutoItensPesquisa').prop("scrollTop", $('#divItensPedido').prop("scrollHeight"));//autoscrool
};

let exibirProdutoPesquisa = function(produto){
	if(produto.urlImagem){
		$('#imgCompraProdutoPesquisaImagem').prop('src', produto.urlImagem);
	}
	else{
		$('#imgCompraProdutoPesquisaImagem').prop('src', imagemInicial);
//		$('#imgCompraProdutoPesquisaImagemCaption').empty();
	}
//	let msgCaption = 'Produto: <strong>' + produto.nome + '</strong>';// Preço: ' + moeda.format(produto.preco)
	let templateDadosProduto = `
		Produto: <strong>${produto.nome}</strong><br>
		Descrição: <strong>${produto.descricao}</strong><br>
		Marca: <strong>${produto.marca}</strong><br>
		Preço: <strong>${moeda.format(produto.preco)}</strong><br>
		Preço prom: <strong>${moeda.format(produto.preco_promocao)}</strong><br>
		Qtd: <strong>${produto.qtd}</strong><br>
		Qtd min:<strong>${produto.qtd_min}</strong><br>
		Qtd max: <strong>${produto.qtd_max}</strong><br>
		Valor compra: <strong>${moeda.format(produto.valor_compra)}</strong><br>
		`;	
	//https://developer.mozilla.org/pt-BR/docs/Web/JavaScript/Reference/template_strings
	$("#divCompraProdutoPesquisaDados").html(templateDadosProduto);
//	$('#imgCompraProdutoPesquisaImagemCaption').html(msgCaption);
//	$('#divCompraProdutoPesquisaMsg').html(msgCaption);	
};

let limparProdutoPesquisa = function(){	
	$("#txtCompraProdutoPesquisaAddQtd, #txtCompraProdutoPesquisaAddValor, #txtCompraProdutoPesquisaAddDesconto").val('');
	$('#imgCompraProdutoPesquisaImagem').prop('src', imagemInicial);
//	$('#imgCompraProdutoPesquisaImagemCaption').empty();
	$("#divCompraProdutoPesquisaDados").empty();
	produtoPesquisaSelecionado = null;
};

export let pesquisarProduto = function(){
	produtoPesquisaSelecionado = null;
    $.ajax({
        url: baseUrl +'api/products/search',
        type: 'POST',
        data:{
        	nome: $('#txtCompraProdutoPesquisaNome').val(),
        	marca: $('#txtCompraProdutoPesquisaMarca').val(),
        	categoria: $('#txtCompraProdutoPesquisaCategoria').val(),
        	cod_barra: $('#txtCompraProdutoPesquisaCodBarra').val(),
        	limit:30,
        	_token: _token
        },
        success: function(data){
        	atualizarListaPesquisa(data.produtos);
        },        
        error: function(jqXhr) {
        	limparListaPesquisa();
        	let parsedJson = jqXhr.responseJSON;
            if( jqXhr.status === 500 ) {
            	$('#divCompraProdutoPesquisaMsg').html(parsedJson.msg);
            }
            if ( jqXhr.status === 404 ) {
            	$('#divCompraProdutoPesquisaMsg').html(parsedJson.msg);
            }
        }
    });	
};
*/
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ })

},[59]);