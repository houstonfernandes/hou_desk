//require("../jquery_validation");//@todo sem o validation na compilacao esta dando erro 20/09/17

import * as pedido from './compra_create';

$(function(){
	$("#preco").val('').prop('disabled','disabled');//preco de diversos
//	$("#cod_barra").focus();
	
	$(document).on('keyup',function(e){
		if(e.keyCode == 9 || e.keyCode == 27 ){//9 tab 111 / 27 esc
			$("#cod_barra").focus().select();
		}
	});
	
	$('form[id=formInserirProduto]').on('keyup',function(e){
		console.log('teclacode: '+ e.keyCode);
		console.log('teclawich: '+ e.wich);
		if(e.keyCode == 111){//111 /
	//		$("#cod_barra").focus().select();
		}
		
		if(e.keyCode == 106){//106 * / 42
		//	$("#qtd").focus().select();
		}
		
		if(e.keyCode == 187){// 187 = 
			pedido.finalizarCompra();
		}
		
		if(e.keyCode == 109){//109 - 
			$( "#btExcluirItem" ).trigger("click");
		}
		
		
	});
    
	let regExpDiversos = new RegExp('^9{3}');
	
	$('#txtFornecedorNome').on('click', function(){
		$("#btPesquisarFornecedor").trigger('click');
	});
	
    $('#btFinalizarCompra').on('click', function(){
    	pedido.finalizarCompra();
    });
    $("#form_compra").submit(function(e){
    	e.preventDefault();
    	console.log(' submit em form compra');
    	
    });
/*
    $("form[name=form]").validate({
        rules: {
            cod_barra:{
                required: true,
                number: true
            },
            qtd:{number:true,
            	required:true,
            	min:1
            }            
        },
        messages: {}
    });
    */
});

