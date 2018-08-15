let moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
export let itens = $('#itensPedido').data('itens'); //inicial;

export let listarItens = function(){	
	let lista;	
	$.each( itens, function( i, item) {
		let totalItem = (parseFloat(item.preco) - parseFloat(item.desconto)) * item.qtd_entregue;
		let templateItem = `
			<tr>
			<td>${i+1}</td>
			<td>${item.product.nome}</td>
			<td>${item.qtd}</td>
			<td>${item.qtd_entregue}</td>
			<td>${item.product.unidade}</td>
			<td>${moeda.format(item.preco)}</td>
			<td>${moeda.format(item.desconto)}</td>
			<td>${moeda.format(totalItem)}</td>
			<td>        							
				<button type="button" class="btn btn-primary" title='Editar item' data-toggle="modal" data-target="#modalCompraEditarItem" data-item_id="${item.id}">
					<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
				</button>
			</td>
			</tr>
			`;
		lista += templateItem;
	});
	let total = calcularTotal(); 
	let totalItens = moeda.format(total.totalItens);
	lista +=`
	<tr>
		<td colspan="9" class="numero">
			<strong>Total itens: ${totalItens}</strong>
		</td>
	</tr>`;
	$('#itensPedido').html(lista);

};

/**
 * calcula o total do pedido e de itens
 * @return json totalItens, total
 */
export let calcularTotal = function(){
	let totalItens = 0;
    $.each( itens, function( i, item) {
		totalItens += (parseFloat(item.preco) - parseFloat(item.desconto)) * item.qtd_entregue;//parseFloat(item.valor_compra) * item.qtd;
    });
    
    let imposto = $('#imposto').val();
    let frete = $('#frete').val();    
    let total = totalItens + parseFloat(imposto) + parseFloat(frete);
	return {
		totalItens: totalItens,
		total : total
	};	
};

export let atualizarExibicao = function(){
	let total = calcularTotal();
	listarItens();
	$("#txtCompraTotal").val(moeda.format(total.total));	
};

export let finalizarCompra = function(){
	if(itens.length==0){
		$('#destaque').html('Adicione produtos ao pedido');
		return false;
	}

	let total = calcularTotal();
	
    $('#destaque').html("TOTAL " + moeda.format(total.total));
	
	bootbox.confirm({
		message:"Finalizar Compra",
		callback:function(confirm){
			if(confirm){
				atualizarPedido();
			}
		},
		onEscape: function () {
			$('.bootbox.modal').modal('hide');
			$("#modal-pagamento").focus();
        }
	});
};

export let atualizarPedido = function(){
	let id = $("#id").val();
    $.ajax({
        url: baseUrl + 'admin/compras/' + id,
        type: 'PUT',
        data:{
        	itens: itens,
        	//fornecedor_id : $('#fornecedor_id').val(),
        	//user_id: $('#user_id').val(),
        	frete: $('#frete').val(),
        	imposto: $('#imposto').val(),
        	nf: $('#nf').val(),
        	obs: $('#obs').val(),
//        	status: $('#status').val(),
        	_token: _token
        },
        success: function(data){
        	$("#destaque").html(data.msg);
        	console.log(data.tarefas);
        	console.log(data.msg);
        	bootbox.alert(data.msg);
        	
        	location.href= data.urlConsultar;//redirecionar para pedido consultar
        	
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
