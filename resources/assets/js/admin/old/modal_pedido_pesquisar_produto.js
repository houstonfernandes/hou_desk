import { atualizarListaItens, retornaFoco, formatarErro, adicionarItem } from './pedido_create';
let imagemInicial = $("#imagemProduto").prop('src');
let moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
let $linha = $('<tr>');
let $coluna = $('<td>');
let produtoPesquisaSelecionado;
let urlPesquisarProduto;

$('#pesquisar_imagemProduto').prop('src', imagemInicial);

$('#modal-pesquisar-produto').on('keyup', function (e) {
	if(e.keyCode == 106 || e.keyCode == 109){//42 * ou 109 -
		$("#pesquisar_cod_barra").focus();
	}
});

$("form[name=form_pesquisar]").submit(function(e){
	e.preventDefault();
	pesquisarProduto();	
});
$("form[id=pesquisarAdd]").submit(function(e){
	e.preventDefault();
	try{
		let qtd = $("#txtPesquisaAddQtd").val() - 0;
		if (qtd <= 0 || isNaN(qtd)){
			throw 'faltou qtd';
		}
//console.log('qtd'+qtd);
		let produto = {...produtoPesquisaSelecionado};//copia do obj
	    if(produto){
	    	produto.qtd = qtd;
//console.log(produto);
			if(produto.unidade=='un' || produto.unidade=='un.'){//se unidade for un pegar parte inteira					
				produto.qtd = parseInt(produto.qtd);
			}
	    	produto.desconto = $('#desconto').val();//0; //desconto padrao mercado
        	let precoTotal = (parseFloat(produto.preco)-parseFloat(produto.desconto)) * produto.qtd;
        	let msg = produto.qtd + ' x ' + produto.nome + ' ' + moeda.format(produto.preco) + ' = ' + moeda.format(precoTotal);
        	$('#divMsgPesquisa').html(msg);
	    	$('#produto').html(msg);
    		adicionarItem(produto);
    		$("#txtPesquisaAddQtd").val('')
	    }
	}catch(e){
		console.error(e);
		return false;
	}
});

$('#modal-pesquisar-produto').on('show.bs.modal', function (e) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    urlPesquisarProduto = button.data('url');
console.log(`url ${urlPesquisarProduto}`);
let urlTeste = button.data('url');
console.log('url = ' +urlTeste);

	$("#pesquisar_cod_barra").focus();
});

$('#modal-pesquisar-produto').on('hide.bs.modal', function (e) {
	retornaFoco();		
}).on('hidden.bs.modal', function (e) {
	retornaFoco();
});

export let limparListaPesquisa = function(){
	$('#itensPesquisa').empty();
	$('#divMsgPesquisa').empty();
	$('#pesquisar_imagemProduto').prop('src', imagemInicial);
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
//    		console.log('clicou produto');
    		exibirProdutoPesquisa($(this).data('produto'));
    		produtoPesquisaSelecionado = $(this).data('produto');
    	});
    	$('#itensPesquisa').append(linhaItem);    	
    });
    if(produtos.length==1){
    	exibirProdutoPesquisa(produtos[0]);//somente um, exibe
    	produtoPesquisaSelecionado = produtos[0];
    }
//    $('#divItensPesquisa').prop("scrollTop", $('#divItensPedido').prop("scrollHeight"));//autoscrool    
};

let exibirProdutoPesquisa =function(produto){
	if(produto.urlImagem){
		$('#pesquisar_imagemProduto').prop('src', produto.urlImagem);
	}
	else{
		$('#pesquisar_imagemProduto').prop('src', imagemInicial);
	}
	$('#pesquisar_imagemProdutoCaption').html(produto.nome);
	$('#divMsgPesquisa').html(moeda.format(produto.preco));	
};
export let pesquisarProduto = function(){
//console.log('pesquisar produto');
	produtoPesquisaSelecionado=null;
    $.ajax({
        url: baseUrl + 'api/products/search',//urlPesquisarProduto,
        type: 'POST',
        data:{
        	nome: $('#pesquisar_nome').val(),
        	marca: $('#pesquisar_marca').val(),
        	categoria: $('#pesquisar_categoria').val(),
        	cod_barra: $('#pesquisar_cod_barra').val(),
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
            	$('#divMsgPesquisa').html(parsedJson.msg);
            }
            if ( jqXhr.status === 404 ) {
            	$('#divMsgPesquisa').html(parsedJson.msg);
            }
        }
    });	
	
};