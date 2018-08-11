webpackJsonp([14],{

/***/ 3:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "itens", function() { return itens; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "pagamentos", function() { return pagamentos; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "adicionarItem", function() { return adicionarItem; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "atualizarListaItens", function() { return atualizarListaItens; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "calcularTotal", function() { return calcularTotal; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "finalizarCompra", function() { return finalizarCompra; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "gravarPedido", function() { return gravarPedido; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "zerarPagamentos", function() { return zerarPagamentos; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "iniciarPedido", function() { return iniciarPedido; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "formatarErro", function() { return formatarErro; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "setFornecedor", function() { return setFornecedor; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "retornaFoco", function() { return retornaFoco; });
var itens = [];
var imagemInicial = $("#imagemProduto").prop('src');
var msgInicial = $("#destaque").html();
var moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
var $linha = $('<tr>');
var $coluna = $('<td>');
var pagamentos = [];

var adicionarItem = function adicionarItem(produto) {
  itens.push(produto);
  atualizarListaItens();
};

var atualizarListaItens = function atualizarListaItens() {
  $('#itensPedido').empty();
  $.each(itens, function (i, item) {
    var linhaItem = $linha.clone();
    var c0 = $coluna.clone().html(i + 1);
    var c1 = $coluna.clone().html(item.nome);
    var c2 = $coluna.clone().html(item.qtd);
    var c3 = $coluna.clone().html(item.unidade);
    var c4 = $coluna.clone().html(moeda.format(item.valor_compra));
    var c5 = $coluna.clone().html(moeda.format(item.desconto));
    var precoTotal = (parseFloat(item.valor_compra) - parseFloat(item.desconto)) * item.qtd;
    var c6 = $coluna.clone().html(moeda.format(precoTotal));
    linhaItem.append([c0, c1, c2, c3, c4, c5, c6]);
    $('#itensPedido').append(linhaItem);
  });

  $('#divItensPedido').prop("scrollTop", $('#divItensPedido').prop("scrollHeight")); //autoscrool

  $("#destaque").html('SUB-TOTAL ' + moeda.format(calcularTotal()));
};

var calcularTotal = function calcularTotal() {
  var total = 0;
  $.each(itens, function (i, item) {
    total += (parseFloat(item.valor_compra) - parseFloat(item.desconto)) * item.qtd; //parseFloat(item.valor_compra) * item.qtd;
  });
  return total;
};

var finalizarCompra = function finalizarCompra() {
  if (itens.length == 0) {
    $('#destaque').html('Adicione produtos ao pedido');
    return false;
  }

  var total = calcularTotal();

  $('#destaque').html("TOTAL " + moeda.format(total));

  bootbox.confirm({
    message: "Finalizar Compra",
    callback: function callback(confirm) {
      if (confirm) {
        //$('#modal-pagamento').modal('hide');
        //limparListaPagamentos();
        gravarPedido();
        //				troco = 0;//limpa troco
      }
    },
    onEscape: function onEscape() {
      $('.bootbox.modal').modal('hide');
      $("#modal-pagamento").focus();
    }
  });

  //    $('#modal-pagamento').modal('show');
};

var gravarPedido = function gravarPedido() {
  $.ajax({
    url: baseUrl + 'admin/compras/',
    type: 'POST',
    data: {
      itens: itens,
      fornecedor_id: $('#fornecedor_id').val(),
      user_id: $('#user_id').val(),
      frete: $('#frete').val(),
      imposto: $('#imposto').val(),
      nf: $('#nf').val(),
      obs: $('#obs').val(),
      status: $('#status').val(),
      _token: _token
    },
    success: function success(data) {
      $("#destaque").html(data.msg);
      console.log(data.tarefas);
      console.log(data.msg);
      bootbox.alert(data.msg);

      iniciarPedido();
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

var zerarPagamentos = function zerarPagamentos() {
  pagamentos = []; //zerar pagamentos
};

var iniciarPedido = function iniciarPedido() {
  itens = []; //zerar itens
  pagamentos = []; //zerar pagamentos
  atualizarListaItens();
  $('#imagemProduto').prop('src', imagemInicial);
  $("#destaque").html(msgInicial);
  $('#produto').empty();
  retornaFoco();
  //$("#cod_barra").val('').focus();//html não funciona
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

var setFornecedor = function setFornecedor(fornecedor) {
  $('#fornecedor_id').val(fornecedor.id);
  $('#txtFornecedorNome').val(fornecedor.nome);
};

/**
 * retorna o foco do modal
 */
var retornaFoco = function retornaFoco() {
  //	$("#cod_barra").focus();
};
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 53:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(54);


/***/ }),

/***/ 54:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "limparListaPesquisa", function() { return limparListaPesquisa; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "atualizarListaPesquisa", function() { return atualizarListaPesquisa; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "pesquisarProduto", function() { return pesquisarProduto; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__compra_create__ = __webpack_require__(3);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };


var imagemInicial = $("#imagemProduto").prop('src');
var moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
var $linha = $('<tr>');
var $coluna = $('<td>');
var produtoPesquisaSelecionado = void 0;
var urlPesquisaProduto = void 0; //@todo pegar do botao

$('#imgCompraProdutoPesquisaImagem').prop('src', imagemInicial);

$('#modalCompraPesquisarProduto').on('keyup', function (e) {
	if (e.keyCode == 106 || e.keyCode == 109) {
		//42 * ou 109 -
		$("#txtCompraProdutoPesquisaCodBarra").focus();
	}
});

$("#formProdutoPesquisar").submit(function (e) {
	e.preventDefault();
	pesquisarProduto();
});

$("#formProdutoPesquisarAdd").submit(function (e) {
	e.preventDefault();
	try {
		var qtd = $("#txtCompraProdutoPesquisaAddQtd").val() - 0;
		var produto = _extends({}, produtoPesquisaSelecionado); //JSON.parse(JSON.stringify(produtoPesquisaSelecionado))//{produtoPesquisaSelecionado};//copia do objeto https://stackoverflow.com/questions/18359093/how-to-copy-javascript-object-to-new-variable-not-by-reference
		//console.log(produto);
		if (!produto) {
			throw 'Faltou selecionar o produto.';
		}
		if (qtd <= 0 || isNaN(qtd)) {
			throw 'Faltou informar a quantidade.';
		}
		produto.qtd = qtd;
		var valorCompra = $("#txtCompraProdutoPesquisaAddValor").val() - 0;
		if (valorCompra <= 0 || isNaN(valorCompra)) {
			throw ' Faltou informar o valor de compra.';
		}
		produto.valor_compra = valorCompra;
		//console.log(produto);
		if (produto.unidade == 'un' || produto.unidade == 'un.') {
			//se unidade for un pegar parte inteira					
			produto.qtd = parseInt(produto.qtd);
		}
		var desconto = $('#txtCompraProdutoPesquisaAddDesconto').val() - 0;
		if (isNaN(desconto)) {
			desconto = 0;
		}
		produto.desconto = desconto;
		var precoTotal = (parseFloat(produto.valor_compra) - parseFloat(produto.desconto)) * produto.qtd;
		var msg = '\n    \tAdicionado: ' + produto.qtd + ' x ' + produto.nome + '<br> \n    \tValor: ' + moeda.format(produto.valor_compra) + ' Desc: ' + moeda.format(produto.desconto) + ' Total: ' + moeda.format(precoTotal);
		$('#divCompraProdutoPesquisaMsg').html(msg);
		$('#produto').html(msg);
		Object(__WEBPACK_IMPORTED_MODULE_0__compra_create__["adicionarItem"])(produto);
		limparProdutoPesquisa();
	} catch (e) {
		$('#divCompraProdutoPesquisaMsg').html(e);
		return false;
	}
});

$('#modalCompraPesquisarProduto').on('show.bs.modal', function (e) {
	var button = $(event.relatedTarget); // Button that triggered the modal
	//urlPesquisaProduto = button.data('url');
	//console.log('url = ' +urlPesquisaProduto);
	$("#txtCompraProdutoPesquisaCodBarra").focus();
});

$('#modalCompraPesquisarProduto').on('hide.bs.modal', function (e) {
	Object(__WEBPACK_IMPORTED_MODULE_0__compra_create__["retornaFoco"])();
}).on('hidden.bs.modal', function (e) {
	Object(__WEBPACK_IMPORTED_MODULE_0__compra_create__["retornaFoco"])();
});

var limparListaPesquisa = function limparListaPesquisa() {
	$('#tbCompraProdutoItensPesquisa').empty();
	$('#divCompraProdutoPesquisaMsg').empty();
	$('#imgCompraProdutoPesquisaImagem').prop('src', imagemInicial);
};

var atualizarListaPesquisa = function atualizarListaPesquisa(produtos) {
	limparListaPesquisa();
	$.each(produtos, function (i, item) {
		var linhaItem = $linha.clone();
		var c0 = $coluna.clone().html(i + 1);
		var c1 = $coluna.clone().html(item.nome);
		var c2 = $coluna.clone().html(item.unidade);
		var c3 = $coluna.clone().html(moeda.format(item.preco));
		linhaItem.append([c0, c1, c2, c3]).data('produto', item).on('click', function () {
			exibirProdutoPesquisa($(this).data('produto'));
			produtoPesquisaSelecionado = $(this).data('produto');
		});
		$('#tbCompraProdutoItensPesquisa').append(linhaItem);
	});
	if (produtos.length == 1) {
		exibirProdutoPesquisa(produtos[0]); //somente um, exibe
		produtoPesquisaSelecionado = produtos[0];
	}
	//    $('#divCompraProdutoItensPesquisa').prop("scrollTop", $('#divItensPedido').prop("scrollHeight"));//autoscrool
};

var exibirProdutoPesquisa = function exibirProdutoPesquisa(produto) {
	if (produto.urlImagem) {
		$('#imgCompraProdutoPesquisaImagem').prop('src', produto.urlImagem);
	} else {
		$('#imgCompraProdutoPesquisaImagem').prop('src', imagemInicial);
		//		$('#imgCompraProdutoPesquisaImagemCaption').empty();
	}
	//	let msgCaption = 'Produto: <strong>' + produto.nome + '</strong>';// Preço: ' + moeda.format(produto.preco)
	var templateDadosProduto = '\n\t\tProduto: <strong>' + produto.nome + '</strong><br>\n\t\tDescri\xE7\xE3o: <strong>' + produto.descricao + '</strong><br>\n\t\tMarca: <strong>' + produto.marca + '</strong><br>\n\t\tPre\xE7o: <strong>' + moeda.format(produto.preco) + '</strong><br>\n\t\tPre\xE7o prom: <strong>' + moeda.format(produto.preco_promocao) + '</strong><br>\n\t\tQtd: <strong>' + produto.qtd + '</strong><br>\n\t\tQtd min:<strong>' + produto.qtd_min + '</strong><br>\n\t\tQtd max: <strong>' + produto.qtd_max + '</strong><br>\n\t\tValor compra: <strong>' + moeda.format(produto.valor_compra) + '</strong><br>\n\t\t';
	//https://developer.mozilla.org/pt-BR/docs/Web/JavaScript/Reference/template_strings
	$("#divCompraProdutoPesquisaDados").html(templateDadosProduto);
	//	$('#imgCompraProdutoPesquisaImagemCaption').html(msgCaption);
	//	$('#divCompraProdutoPesquisaMsg').html(msgCaption);	
};

var limparProdutoPesquisa = function limparProdutoPesquisa() {
	$("#txtCompraProdutoPesquisaAddQtd, #txtCompraProdutoPesquisaAddValor, #txtCompraProdutoPesquisaAddDesconto").val('');
	$('#imgCompraProdutoPesquisaImagem').prop('src', imagemInicial);
	//	$('#imgCompraProdutoPesquisaImagemCaption').empty();
	$("#divCompraProdutoPesquisaDados").empty();
	produtoPesquisaSelecionado = null;
};

var pesquisarProduto = function pesquisarProduto() {
	produtoPesquisaSelecionado = null;
	$.ajax({
		url: baseUrl + 'api/products/search',
		type: 'POST',
		data: {
			nome: $('#txtCompraProdutoPesquisaNome').val(),
			marca: $('#txtCompraProdutoPesquisaMarca').val(),
			categoria: $('#txtCompraProdutoPesquisaCategoria').val(),
			cod_barra: $('#txtCompraProdutoPesquisaCodBarra').val(),
			limit: 30,
			_token: _token
		},
		success: function success(data) {
			atualizarListaPesquisa(data.produtos);
		},
		error: function error(jqXhr) {
			limparListaPesquisa();
			var parsedJson = jqXhr.responseJSON;
			if (jqXhr.status === 500) {
				$('#divCompraProdutoPesquisaMsg').html(parsedJson.msg);
			}
			if (jqXhr.status === 404) {
				$('#divCompraProdutoPesquisaMsg').html(parsedJson.msg);
			}
		}
	});
};
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ })

},[53]);