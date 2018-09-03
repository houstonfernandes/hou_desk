$(function(){
	$("form[name=form]").validate({
		rules: {
			nome:{required: true, minlength:2, maxlength:80},
			data_aquisicao:{dateBR:true},
			setor_id:{required:true},
			tipo_equipamento_id: {required:true},
		}
	});
	
	$('#data_aquisicao').datepicker('option', 'minDate', new Date(1990, 1-1, 1))
		.datepicker('option', 'maxDate', new Date());
/*	.submit(function(e){
		console.log('parou');
		e.preventDefault();
		
	});
	*/
});