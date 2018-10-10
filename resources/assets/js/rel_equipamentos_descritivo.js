$(function(){
	local_id = $('#local_id').val();
	
	if(local_id != ''){
		listarSetores();
	}
	
	$('#local_id').on('change',function(){
		local_id = $(this).val(); 
		if(local_id == ''){
			limparSetores();
			return false;
		}
		listarSetores();
	});
	
	
});

let local_id;
let limparSetores = function(){
	$('#setor_id').empty();
};

let listarSetores = function(){ //buscar locais e montar options
    $.ajax({
        url: baseUrl + 'api/locais/listar_setores/' + local_id,
        type: 'GET',
        data:{
//	        	_token: _token
        },
        success: function(data){
        	console.log(data.msg);
        	$('#setor_id').empty();
    		let $option = $('<option>').prop({
    			'value': '','selected':'selected'
    		}).html('todos');
    		$('#setor_id').append($option);
    		let selected = $('#setor_id_value').val();
        	$.each(data.setores, function(i, setor){
        		let texto = setor.nome;	        		
        		let $option = $('<option>').prop({
        			'value': setor.id,
        		});
        		if( selected == setor.id){
        			$option.prop('selected','selected');
        		}
        		$option.html(texto);
	        	$('#setor_id').append($option);
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
	        	$('#setor_id').html($option);
            	//$('#divMsg').html(parsedJson.msg);
            }
        }
    });	
};
