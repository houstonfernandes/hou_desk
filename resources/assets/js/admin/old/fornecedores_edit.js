$("form[name=form]").validate({
    rules: {
        nome:{required: true, minlength:3, maxlength:80},
        email:{email:true},
    }
});

//$('#cpf').mask('###.#####-####');


// -------------MASCARA EM CAMPOS
	$("#cep").mask("#####-###");
	
let tipoFornecedor = $('#tipo_fornecedor').val();

switch(tipoFornecedor){
	case'0':
		//$("#cpf").mask("###.###.###-##");
		$('#nome_fantasia').prop("disabled", true);
		break;
	case'1':
	//    $("#cpf").mask("##.###.###-####/##");
	    $('#nome_fantasia').prop("disabled", false);	
		break;
}
