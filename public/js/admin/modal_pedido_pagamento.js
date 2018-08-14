webpackJsonp([10],{

/***/ 2:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "pagamentos", function() { return pagamentos; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "buscarProdutoCodBarra", function() { return buscarProdutoCodBarra; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "adicionarItem", function() { return adicionarItem; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "atualizarListaItens", function() { return atualizarListaItens; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "calcularTotal", function() { return calcularTotal; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "finalizarCompra", function() { return finalizarCompra; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "gravarPedido", function() { return gravarPedido; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "zerarPagamentos", function() { return zerarPagamentos; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "iniciarPedido", function() { return iniciarPedido; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "formatarErro", function() { return formatarErro; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "itens", function() { return itens; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "retornaFoco", function() { return retornaFoco; });
var itens = [];
var imagemInicial = $("#imagemProduto").prop('src');
var msgInicial = $("#destaque").html();
var moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
var $linha = $('<tr>');
var $coluna = $('<td>');
var pagamentos = [];

var buscarProdutoCodBarra = function buscarProdutoCodBarra(id, inserir) {
  if (id == null || id.trim() == '') return false;
  $.ajax({
    url: baseUrl + '/api/products/cod_barra/' + id,
    type: 'GET',
    success: function success(data) {
      $('#imagemProduto').prop('src', imagemInicial);
      var produto = data.produto;
      if (produto) {
        produto.qtd = $('#qtd').val();
        //  console.log(produto); 
        if (produto.urlImagem) {
          $('#imagemProduto').prop('src', produto.urlImagem);
        }
        if (produto.unidade == 'un' || produto.unidade == 'un.') {
          //se unidade for un pegar parte inteira					
          produto.qtd = parseInt(produto.qtd);
        }
        produto.desconto = $('#desconto').val(); //0; //desconto padrao mercado
        var isDiversos = id == '9999999999999' ? true : false;
        var precoDiversos = $('#preco').val();
        //  	console.log('id='+id+' preco div='+precoDiversos);
        if (precoDiversos < 0 || precoDiversos == '' && isDiversos) {
          $('#destaque').html('Informe o preco'); //se for diversos solicita preço
          $('#preco').prop('disabled', '').focus();
          precoDiversos = 0;
          $('#produto').html(produto.nome);
          return false;
        }
        if (isDiversos) {
          produto.preco = parseFloat(precoDiversos);
        }
        var precoTotal = (parseFloat(produto.preco) - parseFloat(produto.desconto)) * produto.qtd;

        $('#produto').html(produto.qtd + ' x ' + produto.nome + ' ' + moeda.format(produto.preco) + ' = ' + moeda.format(precoTotal));
        if (inserir) {
          adicionarItem(produto);
        }
        //$("#cod_barra").focus().select();    	    	
        $("#preco").prop('disabled', 'disabled').val(''); //preco de diversos
        $("#cod_barra").focus().val('');
      } else {
        $('#produto').html("produto não encontrado: " + id);
        $("#cod_barra").focus().val('');
        return false;
      }
    },
    error: function error(jqXhr) {
      $('#imagemProduto').prop('src', imagemInicial);
      var parsedJson = jqXhr.responseJSON;
      if (jqXhr.status === 500) {
        $('#produto').html(parsedJson.msg);
      }
      if (jqXhr.status === 404) {
        $('#produto').html(parsedJson.msg);
      }
    }
  });
};

var adicionarItem = function adicionarItem(produto) {
  itens.push(produto);
  atualizarListaItens();
  $("#qtd").val(1);
  $("#cod_barra").val('');
};

var atualizarListaItens = function atualizarListaItens() {
  $('#itensPedido').empty();
  $.each(itens, function (i, item) {
    var linhaItem = $linha.clone();
    var c0 = $coluna.clone().html(i + 1);
    var c1 = $coluna.clone().html(item.nome);
    var c2 = $coluna.clone().html(item.qtd);
    var c3 = $coluna.clone().html(item.unidade);
    var c4 = $coluna.clone().html(moeda.format(item.preco));
    var precoTotal = parseFloat(item.preco) * item.qtd;
    var c5 = $coluna.clone().html(moeda.format(precoTotal));
    linhaItem.append([c0, c1, c2, c3, c4, c5]);
    $('#itensPedido').append(linhaItem);
  });

  $('#divItensPedido').prop("scrollTop", $('#divItensPedido').prop("scrollHeight")); //autoscrool

  $("#destaque").html('SUB-TOTAL ' + moeda.format(calcularTotal()));
};

var calcularTotal = function calcularTotal() {
  var total = 0;
  $.each(itens, function (i, item) {
    total += parseFloat(item.preco) * item.qtd;
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

  $('#modal-pagamento').modal('show');
};

var gravarPedido = function gravarPedido() {
  $.ajax({
    url: baseUrl + '/api/pedidos/store',
    type: 'POST',
    data: {
      itens: itens,
      user_id: $('#user_id').val(),
      cliente_id: $('#cliente_id').val(),
      status: $('#status').val(),
      pagamentos: pagamentos,
      _token: _token
    },
    success: function success(data) {
      //exibirAlerta(data.msg,'success');
      console.log(data.tarefas);
      console.log(data.msg);
      /*        	if(!confirm('gravou pedido limpar')){
              		return false;
              	}
      */
      iniciarPedido();
      //caixa livre
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

/**
 * retorna o foco do modal
 */
var retornaFoco = function retornaFoco() {
  $("#cod_barra").focus();
};


/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ }),

/***/ 46:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(47);


/***/ }),

/***/ 47:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "atualizarListaPagamentos", function() { return atualizarListaPagamentos; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__pedido_create__ = __webpack_require__(2);


var moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
var $linha = $('<tr>');
var $coluna = $('<td>');
var troco = 0;

$('#modal-pagamento').on('keyup', function (e) {
	if (e.keyCode == 111 || e.keyCode == 187) {
		//42 * ou 106 * 111 / 187=
		$("#pagamento_valor").focus();
	}
	if (e.keyCode == 106) {
		// 106 * 109 -
		$("#pagamento_forma").focus();
	}
});

$('#pagamento_forma').on('change', function () {
	var saldo = calcularSaldo();
	if ($(this).val() != 0) {
		$('#pagamento_valor').val(saldo);
	}
});

$('form#formPagamento').submit(function (e) {
	e.preventDefault();
	var valor = $("#pagamento_valor").val();
	if (valor <= 0 || valor.trim() == '') {
		return false;
	}
	valor = parseFloat(valor);
	var forma_id = $("#pagamento_forma").val();
	var forma_nome = $("#pagamento_forma option:selected").text();
	var saldo = adicionarPagamento(valor, forma_id, forma_nome); //saldo restante	
	atualizarListaPagamentos();
	exibirSaldo();
	if (saldo <= 0) {
		//se passar do valor desabilita adicionar
		$('#pagamento_valor, #pagamento_forma, #btPagamentoAdd').prop('disabled', 'disabled');
		$('form#pagamentoFinalizar #btConfirmarPagamento').focus(); //chama foco ao form finalizar Pagamento
		return false;
	}
	$("#pagamento_valor").val(saldo);
});

/**
 * Adiciona pagamento e retorna saldo
 * @return saldo
 */
var adicionarPagamento = function adicionarPagamento(valor, forma_id, forma_nome) {
	var saldo = calcularSaldo();
	if (valor > saldo && forma_id != 0) {
		//só adiciona acima do valor se for dinheiro
		$("#pagamento_valor").val(saldo);
		return saldo;
	}
	if (valor > saldo) {
		troco = valor - saldo;
	}
	__WEBPACK_IMPORTED_MODULE_0__pedido_create__["pagamentos"].push({
		forma_id: forma_id,
		forma_nome: forma_nome,
		valor: valor
	});
	return (saldo - valor).toFixed(2);
};

$("form[id=pagamentoFinalizar]").submit(function (e) {
	e.preventDefault();
	var saldo = exibirSaldo();
	if (saldo > 0) {
		return false;
	}

	bootbox.confirm({
		message: "Finalizar Compra",
		callback: function callback(confirm) {
			if (confirm) {
				// receber(); //forma pg etc
				//imprimir
				//exibirAlerta('finalizando compra','warning');
				$('#modal-pagamento').modal('hide');
				limparListaPagamentos();
				Object(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["gravarPedido"])();
				troco = 0; //limpa troco
			}
		},
		onEscape: function onEscape() {
			$('.bootbox.modal').modal('hide');
			$("#modal-pagamento").focus();
		}
	});
});

$('#modal-pagamento').on('shown.bs.modal', function (e) {
	var saldo = exibirSaldo();
	atualizarListaPagamentos();
	$('#pagamento_valor, #pagamento_forma, #btPagamentoAdd').prop('disabled', false);
	$("#pagamento_valor").focus();

	if (saldo <= 0) {
		//so adiciona se saldo for positivo
		$('#modal-pagamento').focus(); //foco p modal
	}
});

$('#modal-pagamento').on('hidden.bs.modal', function (e) {
	Object(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["zerarPagamentos"])();
});

var calcularSaldo = function calcularSaldo() {
	var saldo = Object(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["calcularTotal"])();
	if (__WEBPACK_IMPORTED_MODULE_0__pedido_create__["pagamentos"].length == 0) {
		return saldo.toFixed(2);
	}
	$.each(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["pagamentos"], function (i, item) {
		saldo -= parseFloat(item.valor);
	});
	return saldo.toFixed(2);
};

/**
 * exibe saldo em #pagamentoDestaque
 * @return saldo
 */
var exibirSaldo = function exibirSaldo() {
	var saldo = calcularSaldo();
	$('#pagamentoDestaque').html("<h1>Total " + moeda.format(Object(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["calcularTotal"])()) + "</h1>");
	if (saldo < 0) {
		$('#pagamentoDestaque').append('<h1>Troco: ' + moeda.format(troco)) + "</h1>";
	} else if (saldo > 0) {
		$('#pagamentoDestaque').append('<h1>Restam: ' + moeda.format(saldo) + '</h1>');
	} else {
		$('#pagamentoDestaque').append('<h1>Pago</h1> ');
	}
	return saldo;
};

var limparListaPagamentos = function limparListaPagamentos() {
	$('#itensPagamento').empty();
	//	$('#pagamento_valor').empty();
};

var atualizarListaPagamentos = function atualizarListaPagamentos() {
	limparListaPagamentos();
	$.each(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["pagamentos"], function (i, item) {
		var linhaItem = $linha.clone();
		var c0 = $coluna.clone().html(i + 1);
		var c1 = $coluna.clone().html(item.forma_id + ' - ' + item.forma_nome);
		var c2 = $coluna.clone().html(moeda.format(item.valor));
		linhaItem.append([c0, c1, c2]);
		$('#itensPagamento').append(linhaItem);
		var troco = item.troco;
		if (troco > 0) {
			var _linhaItem = $linha.clone();
			var _c = $coluna.clone().html(i + 1);
			var _c2 = $coluna.clone().html("TROCO");
			var _c3 = $coluna.clone().html(moeda.format(item.troco));
			_linhaItem.append([_c, _c2, _c3]);
			$('#itensPagamento').append(_linhaItem);
		}
	});
	$('#divItensPagamento').prop("scrollTop", $('#itensPagamento').prop("scrollHeight")); //autoscrool
};
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ })

},[46]);