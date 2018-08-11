webpackJsonp([9],{

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

/***/ 44:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(45);


/***/ }),

/***/ 45:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "limparListaPesquisa", function() { return limparListaPesquisa; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "atualizarListaPesquisa", function() { return atualizarListaPesquisa; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "pesquisarProduto", function() { return pesquisarProduto; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__pedido_create__ = __webpack_require__(2);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };


var imagemInicial = $("#imagemProduto").prop('src');
var moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
var $linha = $('<tr>');
var $coluna = $('<td>');
var produtoPesquisaSelecionado = void 0;
var urlPesquisarProduto = void 0;

$('#pesquisar_imagemProduto').prop('src', imagemInicial);

$('#modal-pesquisar-produto').on('keyup', function (e) {
  if (e.keyCode == 106 || e.keyCode == 109) {
    //42 * ou 109 -
    $("#pesquisar_cod_barra").focus();
  }
});

$("form[name=form_pesquisar]").submit(function (e) {
  e.preventDefault();
  pesquisarProduto();
});
$("form[id=pesquisarAdd]").submit(function (e) {
  e.preventDefault();
  try {
    var qtd = $("#txtPesquisaAddQtd").val() - 0;
    if (qtd <= 0 || isNaN(qtd)) {
      throw 'faltou qtd';
    }
    //console.log('qtd'+qtd);
    var produto = _extends({}, produtoPesquisaSelecionado); //copia do obj
    if (produto) {
      produto.qtd = qtd;
      //console.log(produto);
      if (produto.unidade == 'un' || produto.unidade == 'un.') {
        //se unidade for un pegar parte inteira					
        produto.qtd = parseInt(produto.qtd);
      }
      produto.desconto = $('#desconto').val(); //0; //desconto padrao mercado
      var precoTotal = (parseFloat(produto.preco) - parseFloat(produto.desconto)) * produto.qtd;
      var msg = produto.qtd + ' x ' + produto.nome + ' ' + moeda.format(produto.preco) + ' = ' + moeda.format(precoTotal);
      $('#divMsgPesquisa').html(msg);
      $('#produto').html(msg);
      Object(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["adicionarItem"])(produto);
      $("#txtPesquisaAddQtd").val('');
    }
  } catch (e) {
    console.error(e);
    return false;
  }
});

$('#modal-pesquisar-produto').on('show.bs.modal', function (e) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  urlPesquisarProduto = button.data('url');
  console.log('url ' + urlPesquisarProduto);
  var urlTeste = button.data('url');
  console.log('url = ' + urlTeste);

  $("#pesquisar_cod_barra").focus();
});

$('#modal-pesquisar-produto').on('hide.bs.modal', function (e) {
  Object(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["retornaFoco"])();
}).on('hidden.bs.modal', function (e) {
  Object(__WEBPACK_IMPORTED_MODULE_0__pedido_create__["retornaFoco"])();
});

var limparListaPesquisa = function limparListaPesquisa() {
  $('#itensPesquisa').empty();
  $('#divMsgPesquisa').empty();
  $('#pesquisar_imagemProduto').prop('src', imagemInicial);
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
      //    		console.log('clicou produto');
      exibirProdutoPesquisa($(this).data('produto'));
      produtoPesquisaSelecionado = $(this).data('produto');
    });
    $('#itensPesquisa').append(linhaItem);
  });
  if (produtos.length == 1) {
    exibirProdutoPesquisa(produtos[0]); //somente um, exibe
    produtoPesquisaSelecionado = produtos[0];
  }
  //    $('#divItensPesquisa').prop("scrollTop", $('#divItensPedido').prop("scrollHeight"));//autoscrool    
};

var exibirProdutoPesquisa = function exibirProdutoPesquisa(produto) {
  if (produto.urlImagem) {
    $('#pesquisar_imagemProduto').prop('src', produto.urlImagem);
  } else {
    $('#pesquisar_imagemProduto').prop('src', imagemInicial);
  }
  $('#pesquisar_imagemProdutoCaption').html(produto.nome);
  $('#divMsgPesquisa').html(moeda.format(produto.preco));
};
var pesquisarProduto = function pesquisarProduto() {
  //console.log('pesquisar produto');
  produtoPesquisaSelecionado = null;
  $.ajax({
    url: baseUrl + 'api/products/search', //urlPesquisarProduto,
    type: 'POST',
    data: {
      nome: $('#pesquisar_nome').val(),
      marca: $('#pesquisar_marca').val(),
      categoria: $('#pesquisar_categoria').val(),
      cod_barra: $('#pesquisar_cod_barra').val(),
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
        $('#divMsgPesquisa').html(parsedJson.msg);
      }
      if (jqXhr.status === 404) {
        $('#divMsgPesquisa').html(parsedJson.msg);
      }
    }
  });
};
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(0)))

/***/ })

},[44]);