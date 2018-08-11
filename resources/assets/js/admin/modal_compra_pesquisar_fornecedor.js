import { setFornecedor } from './compra_create';

let moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
let $linha = $('<tr>');
let $coluna = $('<td>');
let fornecedorPesquisaSelecionado;
let urlPesquisaFornecedor;
$("#modalPesquisarFornecedor").on('show.bs.modal', function (event) {
	  let button = $(event.relatedTarget) // Button that triggered the modal
	  urlPesquisaFornecedor = button.data('url');
	  //console.log('url = ' +urlPesquisaFornecedor);
});
$("form[name=formPesquisarFornecedor]").submit(function(e){
	e.preventDefault();
	pesquisarFornecedor();	
});

$("#formPesquisaFornecedorSelecionar").submit(function(e){
	e.preventDefault();
	if(fornecedorPesquisaSelecionado){
		setFornecedor(fornecedorPesquisaSelecionado);
	}
	$("#modalPesquisarFornecedor").modal('hide');
});

export let limparListaPesquisaFornecedor = function(){
	$('#tbPesquisarFornecedorItens').empty();
	$('#divPesquisarFornecedorMsg').empty();
};

export let atualizarListaPesquisaFornecedor = function(fornecedores){	
	limparListaPesquisaFornecedor();
    $.each( fornecedores, function( i, item) {
    	let linhaItem = $linha.clone();
    	let c0 = $coluna.clone().html(i+1);
    	let c1 = $coluna.clone().html(item.nome);
    	let c2 = $coluna.clone().html(item.nome_fantasia);
    	let c3 = $coluna.clone().html(item.email);
    	let c4 = $coluna.clone().html(item.tel);
    	let c5 = $coluna.clone().html(item.cel);
    	linhaItem.append([c0, c1, c2, c3, c4, c5]).data('fornecedor', item).on('click', function(){
    		exibirFornecedorPesquisa($(this).data('fornecedor'));
    		fornecedorPesquisaSelecionado = $(this).data('fornecedor');
    	});
    	$('#tbPesquisarFornecedorItens').append(linhaItem);    	
    });
};

let exibirFornecedorPesquisa =function(fornecedor){
	$('#txtPesquisarFornecedorSelecionado').val(fornecedor.nome);
};

export let pesquisarFornecedor = function(){
//console.log('pesquisar fornecedor');
	fornecedorPesquisaSelecionado=null;
    $.ajax({
        url: urlPesquisaFornecedor,//baseUrl +'api/fornecedores/search',
        type: 'POST',
        data:{
        	nome: $('#txtPesquisarFornecedorNome').val(),
        	nome_fantasia: $('#txtPesquisarFornecedorNomeFantasia').val(),
        	endereco: $('#txtPesquisarFornecedorEndereco').val(),
        	cidade: $('#txtPesquisarFornecedorCidade').val(),
        	email: $('#txtPesquisarFornecedorEmail').val(),
        	limit:30,
        	_token: _token
        },
        success: function(data){
//console.log(data.fornecedores);
        	atualizarListaPesquisaFornecedor(data.fornecedores);
        },        
        error: function(jqXhr) {
        	limparListaPesquisaFornecedor();
        	let parsedJson = jqXhr.responseJSON;
            if( jqXhr.status === 500 ) {
            	$('#divPesquisarFornecedorMsg').html(parsedJson.msg);
            }
            if ( jqXhr.status === 404 ) {
            	$('#divPesquisarFornecedorMsg').html(parsedJson.msg);
            }
        }
    });
};