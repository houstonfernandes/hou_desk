
$("form[name=form]").validate({
    rules: {
        nome:{required: true, minlength:3, maxlength:80},
        email:{email:true},
        cpf:{required:true, verificaCPF:true}
    }
});

$('#cpf').mask('###.#####-####');//pessoa fisica inicial
$('#nome_fantasia').prop("disabled", true);


// -------------MASCARA EM CAMPOS
	$("#cpf").mask("###.###.###-##").focus();//inicia mask cpf
	$("#cep").mask("#####-###");
	
$('#tipo_cliente_juridica').click(//quando ativar cnpj
    function(){
        $("#cpf").mask("##.###.###-####/##").focus();
        $('#nome_fantasia').prop("disabled", false);
    }
);
$('#tipo_cliente_fisica').click(//quando ativar cpf
    function(){
    	$("#cpf").mask("###.###.###-##").focus();
    	$('#nome_fantasia').prop("disabled", true);
    }
);
