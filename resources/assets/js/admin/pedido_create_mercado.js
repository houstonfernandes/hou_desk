//require("../jquery_validation");//@todo sem o validation na compilacao esta dando erro 20/09/17

import * as pedido from './pedido_create';

$(function(){
	$("#preco").val('').prop('disabled','disabled');//preco de diversos
	$("#cod_barra").focus();
	
	$(document).on('keyup',function(e){
		if(e.keyCode == 9 || e.keyCode == 27 ){//9 tab 111 / 27 esc
			$("#cod_barra").focus().select();
		}
	});
	
	$('form[id=formInserirProduto]').on('keyup',function(e){
		console.log('teclacode: '+ e.keyCode);
		console.log('teclawich: '+ e.wich);
		if(e.keyCode == 111){//111 /
			$("#cod_barra").focus().select();
		}
		
		if(e.keyCode == 106){//106 * / 42
			$("#qtd").focus().select();
		}
		
		if(e.keyCode == 187){// 187 = 
			pedido.finalizarCompra();
		}
		
		if(e.keyCode == 109){//109 - 
			$( "#btExcluirItem" ).trigger("click");
		}		
		
		
	});
	
	$("form#formInserirProduto").submit(function(e){
    	e.preventDefault();
    	let id = $('#cod_barra').val();
    	let strId='' + id;//testa se é diversos inicia com 999
        if(regExpDiversos.exec(strId)){
        	id = '9999999999999';
        	$('#cod_barra').val(id);
        }
       	pedido.buscarProdutoCodBarra(id,true);
    });
    
	let regExpDiversos = new RegExp('^9{3}');
	
    $('#btFinalizarCompra').on('click', function(){
    	pedido.finalizarCompra();
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

