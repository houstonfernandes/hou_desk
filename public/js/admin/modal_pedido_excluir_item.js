webpackJsonp([11],{

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

/***/ 42:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(43);


/***/ }),

/***/ 43:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__pedido_create__ = __webpack_require__(2);


$('#modal-excluir-item').on('keyup', function (e) {
	//console.log('MODAL key = ' +e.keyCode)
	if (e.keyCode == 106 || e.keyCode == 109) {
		//42 * ou 109 -
		$("#itemExcluir").focus();
	}
	/*	if( e.keyCode == 13){
 		$('#bt-confirmar-excluir').trigger("click");
 	}
 */
});
/*
$('#bt-confirmar-excluir').on('click', function(){
	$("form[name=form-modal-excluir]").submit();
});
*/

$("form[id=formExcluir]").submit(function (e) {
	e.preventDefault();
	var indice = $('#itemExcluir').val();
	excluirItemPedido(indice);
});

$('#modal-excluir-item').on('show.bs.modal', function (e) {
	if (__WEBPACK_IMPORTED_MODULE_0__pedido_create__["itens"].length == 0) {
		console.log('sem itens para excluir');
		return false;
	}
});

$('#modal-excluir-item').on('shown.bs.modal', function (e) {
	atualizarListaExcluir();
	$('#itemExcluir').focus();
	//var button = $(event.relatedTarget); // Button that triggered the modal
	//$(this).find('#bt-confirmar-excluir').data('url',button.data('url'));
});

$('#modal-excluir-item').on('hide.bs.modal', function (e) {
	$("#cod_barra").focus(); //@todo foco não func
	Object(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["retornaFoco"])();
});
$('#modal-excluir-item').on('hidden.bs.modal', function (e) {
	$("#cod_barra").focus(); //@todo foco não func
	Object(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["retornaFoco"])();
});

var atualizarListaExcluir = function atualizarListaExcluir() {
	$('#itemExcluir').empty();
	var $option = $('<option>');
	$.each(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["itens"], function (i, item) {
		var numero = parseInt(i) + 1;
		var $optionItem = $option.clone().prop({ 'value': i, 'text': numero + " - " + item.nome + ' x ' + item.qtd });
		$('#itemExcluir').append($optionItem);
		//$optionItem.focus();
	});
};

var excluirItemPedido = function excluirItemPedido(indice) {
	var item = __WEBPACK_IMPORTED_MODULE_0__pedido_create__["itens"].splice(indice, 1);
	item = item[0]; //somente exclui um
	//console.log(item);
	$('#produto').html('Item excluído: ' + item.qtd + " x " + item.nome);
	Object(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["atualizarListaItens"])();
	$('#itemExcluir').empty(); //para quando for abrir novamente não aparecer desatualizada    
	$('#modal-excluir-item').modal('hide');
};
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ })

},[42]);