import { atualizarListaItens, retornaFoco, formatarErro, adicionarItem } from './compra_create';
let imagemInicial = $("#imagemProduto").prop('src');
let moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
let $linha = $('<tr>');
let $coluna = $('<td>');
let produtoPesquisaSelecionado;
let urlPesquisaProduto;//@todo pegar do botao

$('#imgCompraProdutoPesquisaImagem').prop('src', imagemInicial);

$('#modalCompraPesquisarProduto').on('keyup', function (e) {
	if(e.keyCode == 106 || e.keyCode == 109){//42 * ou 109 -
		$("#txtCompraProdutoPesquisaCodBarra").focus();
	}
});

$("#formProdutoPesquisar").submit(function(e){
	e.preventDefault();
	pesquisarProduto();	
});

$("#formProdutoPesquisarAdd").submit(function(e){
	e.preventDefault();
	try{		
		let qtd = $("#txtCompraProdutoPesquisaAddQtd").val() - 0;
		let produto =  { ...produtoPesquisaSelecionado };//JSON.parse(JSON.stringify(produtoPesquisaSelecionado))//{produtoPesquisaSelecionado};//copia do objeto https://stackoverflow.com/questions/18359093/how-to-copy-javascript-object-to-new-variable-not-by-reference
//console.log(produto);
		if(!produto){
			throw 'Faltou selecionar o produto.';
		}
		if (qtd <= 0 || isNaN(qtd)){
			throw 'Faltou informar a quantidade.';
		}
		produto.qtd = qtd;
		let valorCompra = $("#txtCompraProdutoPesquisaAddValor").val() - 0;
		if (valorCompra <= 0 || isNaN(valorCompra)){
			throw ' Faltou informar o valor de compra.';
		}	
    	produto.valor_compra = valorCompra;
    	//console.log(produto);
		if(produto.unidade=='un' || produto.unidade=='un.'){//se unidade for un pegar parte inteira					
			produto.qtd = parseInt(produto.qtd);
		}
    	let desconto = $('#txtCompraProdutoPesquisaAddDesconto').val() - 0;
    	if (isNaN(desconto)){
    		desconto = 0;
    	}
    	produto.desconto = desconto;
    	let precoTotal = (parseFloat(produto.valor_compra) - parseFloat(produto.desconto)) * produto.qtd;
    	let msg =`
    	Adicionado: ${produto.qtd} x ${produto.nome}<br> 
    	Valor: ${moeda.format(produto.valor_compra)} Desc: ${moeda.format(produto.desconto)} Total: ${moeda.format(precoTotal)}`;
    	$('#divCompraProdutoPesquisaMsg').html(msg);
    	$('#produto').html(msg);
		adicionarItem(produto);
		limparProdutoPesquisa();
	}catch(e){
		$('#divCompraProdutoPesquisaMsg').html(e);
		return false;
	}
});

$('#modalCompraPesquisarProduto').on('show.bs.modal', function (e) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    //urlPesquisaProduto = button.data('url');
//console.log('url = ' +urlPesquisaProduto);
	$("#txtCompraProdutoPesquisaCodBarra").focus();
});

$('#modalCompraPesquisarProduto').on('hide.bs.modal', function (e) {
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