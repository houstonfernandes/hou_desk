export let itens = [];
let imagemInicial = $("#imagemProduto").prop('src');
let msgInicial = $("#destaque").html();
let moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
let $linha = $('<tr>');
let $coluna = $('<td>');
export let pagamentos = [];

export let adicionarItem = function(produto){
	itens.push(produto);
	atualizarListaItens();
};

export let atualizarListaItens = function(){	
	$('#itensPedido').empty();
    $.each(itens, function( i, item) {
    	let linhaItem = $linha.clone();
    	let c0 = $coluna.clone().html(i+1);
    	let c1 = $coluna.clone().html(item.nome);
    	let c2 = $coluna.clone().html(item.qtd);
    	let c3 = $coluna.clone().html(item.unidade);
    	let c4 = $coluna.clone().html(moeda.format(item.valor_compra));
    	let c5 = $coluna.clone().html(moeda.format(item.desconto));    	
    	let precoTotal = (parseFloat(item.valor_compra) - parseFloat(item.desconto)) * item.qtd; 
    	let c6 = $coluna.clone().html(moeda.format(precoTotal));
    	linhaItem.append([c0, c1, c2, c3, c4, c5, c6]);
    	$('#itensPedido').append(linhaItem);
    });
     
    $('#divItensPedido').prop("scrollTop", $('#divItensPedido').prop("scrollHeight"));//autoscrool
    
    $("#destaque").html('SUB-TOTAL ' + moeda.format(calcularTotal()));
};

export let calcularTotal = function(){
	let total = 0;
    $.each( itens, function( i, item) {
		total+= (parseFloat(item.valor_compra) - parseFloat(item.desconto)) * item.qtd;//parseFloat(item.valor_compra) * item.qtd;
    });
	return total;
};

export let finalizarCompra = function(){
	if(itens.length==0){
		$('#destaque').html('Adicione produtos ao pedido');
		return false;
	}

	let total = calcularTotal();
	
    $('#destaque').html("TOTAL " + moeda.format(total));
	
	bootbox.confirm({
		message:"Finalizar Compra",
		callback:function(confirm){
			if(confirm){
				//$('#modal-pagamento').modal('hide');
				//limparListaPagamentos();
				gravarPedido();
//				troco = 0;//limpa troco
			}
		},
		onEscape: function () {
			$('.bootbox.modal').modal('hide');
			$("#modal-pagamento").focus();
        }
	});

//    $('#modal-pagamento').modal('show');
};

export let gravarPedido = function(){
    $.ajax({
        url: baseUrl + 'admin/compras/',
        type: 'POST',
        data:{
        	itens: itens,
        	fornecedor_id : $('#fornecedor_id').val(),
        	user_id: $('#user_id').val(),
        	frete: $('#frete').val(),
        	imposto: $('#imposto').val(),
        	nf: $('#nf').val(),
        	obs: $('#obs').val(),
        	status: $('#status').val(),
        	_token: _token
        },
        success: function(data){
        	$("#destaque").html(data.msg);
        	console.log(data.tarefas);
        	console.log(data.msg);
        	bootbox.alert(data.msg);
        	
        	iniciarPedido();
        },        
        error: function(jqXhr) {
            let parsedJson = jqXhr.responseJSON;
            if( jqXhr.status === 500 ) {        	                
                $("#destaque").html(parsedJson.msg);
            	console.error(parsedJson.tarefas);
            	console.error(parsedJson.exception);
            }
            if( jqXhr.status === 422 ) {
            	let errorString = formatarErro(parsedJson)
                $("#destaque").html(errorString);
            }
            if ( jqXhr.status === 404 ) {
            	$('#produto').html(parsedJson.msg);
            }
        }
    });
};

export let zerarPagamentos = function(){
	pagamentos = [];//zerar pagamentos
};

export let iniciarPedido = function(){
	itens = [];//zerar itens
	pagamentos = [];//zerar pagamentos
	atualizarListaItens();
	$('#imagemProduto').prop('src', imagemInicial);
	$("#destaque").html(msgInicial);
	$('#produto').empty();
	retornaFoco();
	//$("#cod_barra").val('').focus();//html não funciona
};

export let formatarErro = function(parsedJson){
	let errorString = '';
	$.each( parsedJson.errors, function( key, value) {
		errorString += '<ul>' + key;
		$.each( value, function( i, msg) {
			errorString += '<li>' + msg + '</li>';
		});
		errorString +='</ul>';
	});
	return errorString;
};

export let setFornecedor = function(fornecedor){
    $('#fornecedor_id').val(fornecedor.id);
    $('#txtFornecedorNome').val(fornecedor.nome);
};

/**
 * retorna o foco do modal
 */
export let retornaFoco = function(){
//	$("#cod_barra").focus();
};
