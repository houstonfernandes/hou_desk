let itens = [];
let imagemInicial = $("#imagemProduto").prop('src');
let msgInicial = $("#destaque").html();
let moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
let $linha = $('<tr>');
let $coluna = $('<td>');
export let pagamentos = [];

export let buscarProdutoCodBarra = function(id, inserir){
    if(id == null || id.trim() == '')
        return false;
    $.ajax({
        url: baseUrl +'/api/products/cod_barra/' + id,
        type: 'GET',
        success: function(data){
        	$('#imagemProduto').prop('src', imagemInicial);
        	let produto = data.produto;            
    	    if(produto){
    	    	produto.qtd = $('#qtd').val();
//  console.log(produto); 
    	    	if(produto.urlImagem){
    	    		$('#imagemProduto').prop('src', produto.urlImagem);
    	    	}
				if(produto.unidade=='un' || produto.unidade=='un.'){//se unidade for un pegar parte inteira					
					produto.qtd = parseInt(produto.qtd);
				}
    	    	produto.desconto = $('#desconto').val();//0; //desconto padrao mercado
    	    	let isDiversos = (id == '9999999999999')? true : false;
	        	let precoDiversos = $('#preco').val();
//  	console.log('id='+id+' preco div='+precoDiversos);
	        	if(precoDiversos < 0 || precoDiversos =='' && isDiversos){	        		
	        		$('#destaque').html('Informe o preco');//se for diversos solicita preço
	        		$('#preco').prop('disabled','').focus();
	        		precoDiversos = 0;
	        		$('#produto').html( produto.nome );
	        		return false;
	        	}
	        	if(isDiversos){
	        		produto.preco = parseFloat(precoDiversos);
	        	}	        	
	        	let precoTotal = (parseFloat(produto.preco)-parseFloat(produto.desconto)) * produto.qtd;

    	    	$('#produto').html(produto.qtd + ' x ' + produto.nome + ' ' + moeda.format(produto.preco) + ' = ' + moeda.format(precoTotal));
    	    	if (inserir){
    	    		adicionarItem(produto);
    	    	}
    	    	//$("#cod_barra").focus().select();    	    	
    	    	$("#preco").prop('disabled','disabled').val('');//preco de diversos
    	        $("#cod_barra").focus().val('');
    	    }
    	    else{
    	    	$('#produto').html("produto não encontrado: " + id);
    	    	$("#cod_barra").focus().val('');
    	    	return false;
    	    }
        },        
        error: function(jqXhr) {
        	$('#imagemProduto').prop('src', imagemInicial);
            let parsedJson = jqXhr.responseJSON;
            if( jqXhr.status === 500 ) {
            	$('#produto').html(parsedJson.msg);
            }
            if ( jqXhr.status === 404 ) {
            	$('#produto').html(parsedJson.msg);
            }
        }
    });
};

export let adicionarItem = function(produto){
	itens.push(produto);
	atualizarListaItens();
    $("#qtd").val(1);
    $("#cod_barra").val('');
};

export let atualizarListaItens = function(){	
	$('#itensPedido').empty();
    $.each( itens, function( i, item) {
    	let linhaItem = $linha.clone();
    	let c0 = $coluna.clone().html(i+1);
    	let c1 = $coluna.clone().html(item.nome);
    	let c2 = $coluna.clone().html(item.qtd);
    	let c3 = $coluna.clone().html(item.unidade);
    	let c4 = $coluna.clone().html(moeda.format(item.preco));
    	let precoTotal = parseFloat(item.preco) * item.qtd;
    	let c5 = $coluna.clone().html(moeda.format(precoTotal));
    	linhaItem.append([c0, c1, c2, c3, c4, c5]);
    	$('#itensPedido').append(linhaItem);
    });
    
     
    $('#divItensPedido').prop("scrollTop", $('#divItensPedido').prop("scrollHeight"));//autoscrool
    
    $("#destaque").html('SUB-TOTAL ' + moeda.format(calcularTotal()));
};

export let calcularTotal = function(){
	let total = 0;
    $.each( itens, function( i, item) {
		total+= parseFloat(item.preco) * item.qtd;
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

    $('#modal-pagamento').modal('show');
};

export let gravarPedido = function(){
    $.ajax({
        url: baseUrl +'/api/pedidos/store',
        type: 'POST',
        data:{
        	itens: itens,
        	user_id : $('#user_id').val(),
        	cliente_id: $('#cliente_id').val(),
        	status: $('#status').val(),
        	pagamentos: pagamentos,
        	_token: _token
        },
        success: function(data){
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

/**
 * retorna o foco do modal
 */
let retornaFoco = function(){
	$("#cod_barra").focus();
};

export { itens, retornaFoco };
