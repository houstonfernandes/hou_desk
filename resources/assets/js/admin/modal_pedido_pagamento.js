import { itens, pagamentos, zerarPagamentos, calcularTotal, gravarPedido, retornaFoco, formatarErro } from './pedido_create';

let moeda = new Intl.NumberFormat('pt-br', { style: 'currency', currency: 'BRL' });
let $linha = $('<tr>');
let $coluna = $('<td>');
let troco = 0;

$('#modal-pagamento').on('keyup', function (e) {
	if(e.keyCode == 111 || e.keyCode == 187){//42 * ou 106 * 111 / 187=
		$("#pagamento_valor").focus();
	}
	if(e.keyCode == 106){// 106 * 109 -
		$("#pagamento_forma").focus();
	}
});

$('#pagamento_forma').on('change',function(){
	let saldo = calcularSaldo();
	if($(this).val()!=0){
		$('#pagamento_valor').val(saldo);
	}
});

$('form#formPagamento').submit(function(e){
	e.preventDefault();
	let valor = $("#pagamento_valor").val();
	if(valor <= 0 || valor.trim() ==''){
		return false;
	}
	valor = parseFloat(valor);
	let forma_id = $("#pagamento_forma").val();
	let forma_nome  = $("#pagamento_forma option:selected").text();
	let saldo = adicionarPagamento(valor, forma_id, forma_nome);//saldo restante	
	atualizarListaPagamentos();
	exibirSaldo();
	if (saldo <= 0){//se passar do valor desabilita adicionar
		$('#pagamento_valor, #pagamento_forma, #btPagamentoAdd').prop('disabled','disabled')
		$('form#pagamentoFinalizar #btConfirmarPagamento').focus();//chama foco ao form finalizar Pagamento
		return false;
	}
	$("#pagamento_valor").val(saldo);
});

/**
 * Adiciona pagamento e retorna saldo
 * @return saldo
 */
let adicionarPagamento = function(valor, forma_id, forma_nome){
	let saldo = calcularSaldo();
	if(valor > saldo && forma_id !=0){//só adiciona acima do valor se for dinheiro
		$("#pagamento_valor").val(saldo);
		return saldo;
	}
	if(valor > saldo){
		troco = valor - saldo;
	}
	pagamentos.push({
		forma_id: forma_id,
		forma_nome: forma_nome,
		valor: valor
	});
	return (saldo - valor).toFixed(2);	
}

$("form[id=pagamentoFinalizar]").submit(function(e){
	e.preventDefault();
	let saldo = exibirSaldo();
	if(saldo > 0){
		return false;
	}
	
	bootbox.confirm({
		message:"Finalizar Compra",
		callback:function(confirm){
			if(confirm){
				 // receber(); //forma pg etc
				//imprimir
				//exibirAlerta('finalizando compra','warning');
				$('#modal-pagamento').modal('hide');
				limparListaPagamentos();
				gravarPedido();
				troco = 0;//limpa troco
			}
		},
		onEscape: function () {
			$('.bootbox.modal').modal('hide');
			$("#modal-pagamento").focus();
        }
	});
});


$('#modal-pagamento').on('shown.bs.modal', function (e) {
	let saldo = exibirSaldo();	
	atualizarListaPagamentos();
	$('#pagamento_valor, #pagamento_forma, #btPagamentoAdd').prop('disabled', false)		
	$("#pagamento_valor").focus();
	
	if (saldo <=0){//so adiciona se saldo for positivo
		$('#modal-pagamento').focus();//foco p modal
	}
});

$('#modal-pagamento').on('hidden.bs.modal', function (e) {
	zerarPagamentos()
});

let calcularSaldo = function(){
	let saldo = calcularTotal();	
	if(pagamentos.length == 0 ){
		return saldo.toFixed(2);
	}
    $.each( pagamentos, function( i, item) {
    	saldo -= parseFloat(item.valor); 
    });
    return saldo.toFixed(2);
}

/**
 * exibe saldo em #pagamentoDestaque
 * @return saldo
 */
let exibirSaldo = function(){	
	let saldo = calcularSaldo();
	$('#pagamentoDestaque').html("<h1>Total " + moeda.format(calcularTotal()) +"</h1>");
	if(saldo < 0){
		$('#pagamentoDestaque').append('<h1>Troco: ' + moeda.format(troco)) +"</h1>";
	}
	else if(saldo > 0){
		$('#pagamentoDestaque').append('<h1>Restam: ' + moeda.format(saldo)+'</h1>');
	}
	else{
		$('#pagamentoDestaque').append('<h1>Pago</h1> ');
	}
	return saldo;
};

let limparListaPagamentos = function(){
	$('#itensPagamento').empty();
//	$('#pagamento_valor').empty();
};

export let atualizarListaPagamentos = function(){	
	limparListaPagamentos();
    $.each( pagamentos, function( i, item) {
    	let linhaItem = $linha.clone();
    	let c0 = $coluna.clone().html(i+1);
    	let c1 = $coluna.clone().html(item.forma_id + ' - ' + item.forma_nome);
    	let c2 = $coluna.clone().html(moeda.format(item.valor));
    	linhaItem.append([c0, c1, c2])
    	$('#itensPagamento').append(linhaItem);
    	let troco = item.troco;
    	if(troco>0){
        	let linhaItem = $linha.clone();
        	let c0 = $coluna.clone().html(i+1);
        	let c1 = $coluna.clone().html("TROCO");
        	let c2 = $coluna.clone().html(moeda.format(item.troco));
        	linhaItem.append([c0, c1, c2])
        	$('#itensPagamento').append(linhaItem);
    	}
    });
    $('#divItensPagamento').prop("scrollTop", $('#itensPagamento').prop("scrollHeight"));//autoscrool
    
};
