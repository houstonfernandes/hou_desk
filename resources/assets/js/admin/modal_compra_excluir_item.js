import { itens, atualizarListaItens, retornaFoco } from './compra_create';

$('#modalCompraExcluirItem').on('keyup', function (e) {
	if(e.keyCode == 106 || e.keyCode == 109){//42 * ou 109 -
		$("#selCompraExcluirItem").focus();
	}
});

$("#formCompraExcluirItem").submit(function(e){
	e.preventDefault();
	let indice = $('#selCompraExcluirItem').val();
	excluirItemPedido(indice);
});

$('#modalCompraExcluirItem').on('show.bs.modal', function (e) {
	try{
		if(itens.length==0){
			throw'sem itens para excluir';
		}
	}
	catch(e){
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
	$( "#cod_barra" ).focus();//@todo foco não func
	retornaFoco();
});

let atualizarListaExcluir = function(){
    $('#selCompraExcluirItem').empty(); 
    let $option = $('<option>');
    $.each(itens, function( i, item) {
    	let numero = parseInt(i) + 1 ;
		let $optionItem = $option.clone().prop({'value' : i, 'text' : numero + " - " + item.nome + ' x ' + item.qtd});
		$('#selCompraExcluirItem').append($optionItem);
		//$optionItem.focus();
    });	
};

let excluirItemPedido = function(indice){
	let item = itens.splice(indice, 1);
	item = item[0];//somente exclui um
//console.log(item);
	$('#produto').html('Item excluído: ' + item.qtd +" x "+ item.nome  );
	atualizarListaItens();
    $('#selCompraExcluirItem').empty();//para quando for abrir novamente não aparecer desatualizada    
	$('#modalCompraExcluirItem').modal('hide');
};
