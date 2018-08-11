import { atualizarExibicao, calcularTotal, itens } from './compra_edit';
//let imagemInicial = $("#imagemProduto").prop('src');
let moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
let $linha = $('<tr>');
let $coluna = $('<td>');
let produtoPesquisaSelecionado;
let urlPesquisaProduto;//@todo pegar do botao
let path = baseUrl + 'product_images/';
let semImagem = 'sem_imagem.jpg';
let indiceEditar;
let itemEditar;
let atualizarDadosModal = function(id){
	try{				
		let item = procurarItem(id);
		itemEditar = item;
console.log(itemEditar);		
		if(!item)
			throw "Item não encontrado";		
		$('#txtCompraEditarItemCodBarra').val(item.product.cod_barra);
		$('#txtCompraEditarItemNome').val(item.product.nome);
		$('#txtCompraEditarItemQtd').val(item.qtd);
		$('#txtCompraEditarItemUnidade').val(item.product.unidade);
		let imageName;
		if(item.product.images.length > 0){
			imageName = `${item.product.images[0].id}.${item.product.images[0].extension}`;
		}
		else{
			imageName = semImagem;
		}
//console.log(`image name: ${path + imageName}`);
		$('#imgCompraProdutoPesquisaImagem').prop('src', path + imageName);
		$('#txtCompraEditarItemQtdEntregue').val(item.qtd_entregue);
		$('#txtCompraEditarItemPreco').val(item.preco);
		$('#txtCompraEditarItemDesconto').val(item.desconto);
		$('#txtCompraEditarItemObs').val(item.obs);
	}catch(e){
	//@todo escrever falha no modal e fechar	
	
		console.log(e);
	}
}

let procurarItem = function(id){
	let saida = null;
    $.each( itens, function( i, item) {
    	if (item.id == id){    		 
    		saida = {...item};//copia do objeto
    		indiceEditar = i;
    		return false; //sair do each
    	}
    });
    return saida;
};

/**
 * Consulta o produto pela API
 */
let consultarProduto = function(id){
	console.log('consultando ajax');
	//produto = null;
    $.ajax({
        url: baseUrl + 'api/products/consultar/'+id,//urlPesquisarProduto,
        type: 'get',
        success: function(data){
        	console.log(data.produto.nome);
        },        
        error: function(jqXhr) {
        	let parsedJson = jqXhr.responseJSON;
            if( jqXhr.status === 500 ) {
//            	$('#divMsgPesquisa').html(parsedJson.msg);
            	console.log('erro 500');            	
            }
            if ( jqXhr.status === 404 ) {
  //          	$('#divMsgPesquisa').html(parsedJson.msg);
            	console.log('erro 404');
            }
        }
    });
};

$('#modalCompraEditarItem').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget); // Button that triggered the modal
    let id = button.data('item_id'); // Extract info from data-* attributes
    atualizarDadosModal(id);//itemEditar);
});

$("#formCompraItemEditar").submit(function(e){
	e.preventDefault();
	//itens[indiceEditar] = itemEditar;
	//atribuir valores a 

	itemEditar.qtd_entregue = $("#txtCompraEditarItemQtdEntregue").val();
	itemEditar.preco = $("#txtCompraEditarItemPreco").val();
	itemEditar.desconto = $("#txtCompraEditarItemDesconto").val();
	itemEditar.obs = $("#txtCompraEditarItemObs").val();
	itens[indiceEditar] = itemEditar;
console.log(itemEditar);	
	atualizarExibicao();
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