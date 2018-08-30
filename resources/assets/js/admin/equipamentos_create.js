$(function(){
	$("form[name=form]").validate({
		rules: {
			nome:{required: true, minlength:2, maxlength:80},
			data_aquisicao:{dateBR:true},
			setor_id:{required:true},
			tipo_equipamento_id: {required:true},
		}
	});
/*	.submit(function(e){
		console.log('parou');
		e.preventDefault();
		
	});
	*/
});