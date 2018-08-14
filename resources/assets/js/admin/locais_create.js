
$("form[name=form]").validate({
    rules: {
        nome:{required: true, minlength:3, maxlength:80},
        email:{email:true},
        cnpj:{required:true, verificaCPF:true}
    }
});
$("#cnpj").mask("##.###.###-####/##").focus();
//$('#cpf').mask('###.#####-####');//pessoa fisica inicial
//$('#nome_fantasia').prop("disabled", true);


// -------------MASCARA EM CAMPOS
//	$("#cpf").mask("###.###.###-##").focus();//inicia mask cpf
	$("#cep").mask("#####-###");
/*	
$('#tipo_fornecedor_juridica').click(//quando ativar cnpj
    function(){
        $("#cnpj").mask("##.###.###-####/##").focus();
        $('#nome_fantasia').prop("disabled", false);
    }
);
$('#tipo_fornecedor_fisica').click(//quando ativar cpf
    function(){
    	$("#cpf").mask("###.###.###-##").focus();
    	$('#nome_fantasia').prop("disabled", true);
    }
);
*/
