$(function(){
	$('#setor_id').on('change',function(){
		let setor_id = $(this).val(); 
		if(setor_id == ''){
			$('#equipamento_id').empty();
			return false;
		}
		//buscar equipamentos
	    $.ajax({
	        url: baseUrl + 'api/equipamentos/listar_setor/' + setor_id,//urlPesquisarProduto,
	        type: 'GET',
	        data:{
//	        	_token: _token
	        },
	        success: function(data){
	        	console.log(data.msg);
	        	$('#equipamento_id').empty();
        		let $option = $('<option>').prop({
        			'value': '','selected':'selected'
        		}).html('Selecione um equipamento');
        		$('#equipamento_id').append($option);
	        	$.each(data.equipamentos, function(i, equipamento){
	        		let texto = equipamento.nome;
	        			texto += (equipamento.descricao != null)? ' - ' + equipamento.descricao:' ';
	        			texto += (equipamento.num_etiqueta != null)? ' - ' + equipamento.num_etiqueta:' ';
	        		
	        		let $option = $('<option>').prop({
	        			'value': equipamento.id,
	        		}).html(texto);
		        	$('#equipamento_id').append($option);
	        	});	        	
	        },        
	        error: function(jqXhr) {	        	
	        	let parsedJson = jqXhr.responseJSON;
	            if( jqXhr.status === 500 ) {
	            	$('#divMsg').html(parsedJson.msg);
	            }
	            if ( jqXhr.status === 404 ) {
	        		let $option = $('<option>').prop({
	        			'value': '',
	        		}).html(parsedJson.msg);
		        	$('#equipamento_id').html($option);
	            	//$('#divMsg').html(parsedJson.msg);
	            }
	        }
	    });	
	});
	
});
