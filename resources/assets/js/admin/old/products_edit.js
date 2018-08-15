
$("form[name=form]").validate({
    rules: {
        nome:{required: true, minlength:3, maxlength:80},
        preco:{required:true, min:0,number:true},
        preco_promocao:{},
        qtd_min:'number',
        qtd_max:'number',
    }
});

$('#preco').blur(function(){
	$("#preco_promocao").rules('add',{    	
    	max: function() {
    		valor = $('#preco').val();
        	if(valor == null || valor == 'undefined'|| valor == '') 
        		return 9999999999;
          	return valor;               
        }
	});
});

$('#promocao').on('click', function(){
	if ($("#promocao").is(':checked')) {
		$("#preco_promocao").rules('add',{
        	required: true
		});
	}
	else
		$('#preco_promocao').rules('remove', 'required');
});

$('form[name=form]').submit( function(e){
	$(this).validate();
});
