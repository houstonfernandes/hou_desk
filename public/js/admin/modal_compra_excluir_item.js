webpackJsonp([16],{

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

/***/ 57:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(58);


/***/ }),

/***/ 58:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__compra_create__ = __webpack_require__(3);


$('#modalCompraExcluirItem').on('keyup', function (e) {
	if (e.keyCode == 106 || e.keyCode == 109) {
		//42 * ou 109 -
		$("#selCompraExcluirItem").focus();
	}
});

$("#formCompraExcluirItem").submit(function (e) {
	e.preventDefault();
	var indice = $('#selCompraExcluirItem').val();
	excluirItemPedido(indice);
});

$('#modalCompraExcluirItem').on('show.bs.modal', function (e) {
	try {
		if (__WEBPACK_IMPORTED_MODULE_0__compra_create__["itens"].length == 0) {
			throw 'sem itens para excluir';
		}
	} catch (e) {
		$('#produto').html(e);
		return false;
	}
});

$('#modalCompraExcluirItem').on('shown.bs.modal', function (e) {
	atualizarListaExcluir();
	$('#selCompraExcluirItem').focus();
	//var button = $(event.relatedTarget); // Button that triggered the modal
	//$(this).find('#bt-confirmar-excluir').data('url',button.data('url'));
});

$('#modalCompraExcluirItem').on('hide.bs.modal', function (e) {
	$("#cod_barra").focus(); //@todo foco não func
	Object(__WEBPACK_IMPORTED_MODULE_0__compra_create__["retornaFoco"])();
});

var atualizarListaExcluir = function atualizarListaExcluir() {
	$('#selCompraExcluirItem').empty();
	var $option = $('<option>');
	$.each(__WEBPACK_IMPORTED_MODULE_0__compra_create__["itens"], function (i, item) {
		var numero = parseInt(i) + 1;
		var $optionItem = $option.clone().prop({ 'value': i, 'text': numero + " - " + item.nome + ' x ' + item.qtd });
		$('#selCompraExcluirItem').append($optionItem);
		//$optionItem.focus();
	});
};

var excluirItemPedido = function excluirItemPedido(indice) {
	var item = __WEBPACK_IMPORTED_MODULE_0__compra_create__["itens"].splice(indice, 1);
	item = item[0]; //somente exclui um
	//console.log(item);
	$('#produto').html('Item excluído: ' + item.qtd + " x " + item.nome);
	Object(__WEBPACK_IMPORTED_MODULE_0__compra_create__["atualizarListaItens"])();
	$('#selCompraExcluirItem').empty(); //para quando for abrir novamente não aparecer desatualizada    
	$('#modalCompraExcluirItem').modal('hide');
};
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ })

},[57]);