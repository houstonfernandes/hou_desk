//require("../jquery_validation");//@todo sem o validation na compilacao esta dando erro 20/09/17

import * as pedido from './compra_edit';

$(function(){
	//console.log(items);
	pedido.atualizarExibicao();
	
	/*
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
    */
	
    $('#imposto, #frete').on('blur', function(){
    	pedido.atualizarExibicao();
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

