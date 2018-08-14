webpackJsonp([8],{

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

/***/ 39:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(40);


/***/ }),

/***/ 40:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__pedido_create__ = __webpack_require__(2);
//require("../jquery_validation");//@todo sem o validation na compilacao esta dando erro 20/09/17



$(function () {
	$("#preco").val('').prop('disabled', 'disabled'); //preco de diversos
	$("#cod_barra").focus();

	$(document).on('keyup', function (e) {
		if (e.keyCode == 9 || e.keyCode == 27) {
			//9 tab 111 / 27 esc
			$("#cod_barra").focus().select();
		}
	});

	$('form[id=formInserirProduto]').on('keyup', function (e) {
		console.log('teclacode: ' + e.keyCode);
		console.log('teclawich: ' + e.wich);
		if (e.keyCode == 111) {
			//111 /
			$("#cod_barra").focus().select();
		}

		if (e.keyCode == 106) {
			//106 * / 42
			$("#qtd").focus().select();
		}

		if (e.keyCode == 187) {
			// 187 = 
			__WEBPACK_IMPORTED_MODULE_0__pedido_create__["finalizarCompra"]();
		}

		if (e.keyCode == 109) {
			//109 - 
			$("#btExcluirItem").trigger("click");
		}
	});

	$("form#formInserirProduto").submit(function (e) {
		e.preventDefault();
		var id = $('#cod_barra').val();
		var strId = '' + id; //testa se é diversos inicia com 999
		if (regExpDiversos.exec(strId)) {
			id = '9999999999999';
			$('#cod_barra').val(id);
		}
		__WEBPACK_IMPORTED_MODULE_0__pedido_create__["buscarProdutoCodBarra"](id, true);
	});

	var regExpDiversos = new RegExp('^9{3}');

	$('#btFinalizarCompra').on('click', function () {
		__WEBPACK_IMPORTED_MODULE_0__pedido_create__["finalizarCompra"]();
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

},[39]);