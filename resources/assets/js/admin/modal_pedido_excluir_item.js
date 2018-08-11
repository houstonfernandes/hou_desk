import { itens, atualizarListaItens, retornaFoco } from './pedido_create';

$('#modal-excluir-item').on('keyup', function (e) {
//console.log('MODAL key = ' +e.keyCode)
	if(e.keyCode == 106 || e.keyCode == 109){//42 * ou 109 -
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

$("form[id=formExcluir]").submit(function(e){
	e.preventDefault();
	let indice = $('#itemExcluir').val();
	excluirItemPedido(indice);
});


$('#modal-excluir-item').on('show.bs.modal', function (e) {
	if(itens.length==0){
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
	$( "#cod_barra" ).focus();//@todo foco não func
	retornaFoco();
});
$('#modal-excluir-item').on('hidden.bs.modal', function (e) {
	$("#cod_barra").focus();//@todo foco não func
	retornaFoco();
});

let atualizarListaExcluir = function(){
    $('#itemExcluir').empty();    
    let $option = $('<option>');
    $.each(itens, function( i, item) {
    	let numero = parseInt(i) + 1 ;
		let $optionItem = $option.clone().prop({'value' : i, 'text' : numero + " - " + item.nome + ' x ' + item.qtd});
		$('#itemExcluir').append($optionItem);
		//$optionItem.focus();
    });	
};

let excluirItemPedido = function(indice){
	let item = itens.splice(indice, 1);
	item = item[0];//somente exclui um
//console.log(item);
	$('#produto').html('Item excluído: ' + item.qtd +" x "+ item.nome  );
	atualizarListaItens();
    $('#itemExcluir').empty();//para quando for abrir novamente não aparecer desatualizada    
	$('#modal-excluir-item').modal('hide');
};
