// configuração e métodos para validator
$(function(){
	$.validator.addMethod('filesize', function (value, element, param) {
		return this.optional(element) || (element.files[0].size <= param)
	}, 'O tamanho do arquivo deve ser no máximo {0} KB.');

	$.validator.addMethod('filesize_mb', function (value, element, param) {
		return this.optional(element) || (element.files[0].size <= param*1024*1024)
	}, 'O tamanho do arquivo deve ser no máximo {0} MB.');

	jQuery.validator.addMethod('atLeastOneChecked', function(value, element) {
		return ($('.checkBoxOne input:checked').length > 0);
		}, 'Selecione pelo menos uma opção.'
	);
	//pelo menos um selecionado no checkbox
	jQuery.validator.addMethod('checkBoxSelectOne', function(value,element){
	    if(element.length>0){
	        for(var i=0;i<element.length;i++){
	            if($(element[i]).val('checked')) return true;
	        }
	        return false;
	    }
	    return false;
	}, 'Selecione pelo menos uma opção.');
	
    //>>> validator dataBR
    jQuery.validator.addMethod("dateBR", function(value, element) {
    	if (value=='')
    		return true;
 	   return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/); },
 	"Entre uma data no formato: dd/mm/aaaa");
  // <<<validator dataBR

    jQuery.validator.addMethod("time", function(value, element) {
		return this.optional(element) || 
		/^([0-1][0-9]|[2][0-3]):[0-5][0-9]$/.test(value);
	}, "Entre uma hora entre: 00:00 e 23:59");

	jQuery.validator.addMethod("hhmmss", function(value, element) {
		return this.optional(element) || 
		/^([0-1][0-9]|[2][0-3]):[0-5][0-9]:[0-5][0-9]$/.test(value);
	}, "Entre uma hora entre: 00:00:00 e 23:59:59");
	
	jQuery.validator.addMethod(
			"semAcento",
		    function(value, element) {
		    	return this.optional(element) || /^([a-zA-Z0-9]|[ ])+$/.test( value );
		    },
		    "Utilize somente letras ou números."
		);
	
	jQuery.validator.addMethod(
			"semAcentoEspaco",
		    function(value, element) {
		    	return this.optional(element) || /^([a-zA-Z0-9])+$/.test( value );
		    },
		    "Utilize somente letras e números, sem espaço."
		);
	
	//metodo verifica CPF se tiver menos que 15 caractesres (com mascara) ou cnpj se for mais caracteres
    jQuery.validator.addMethod("verificaCPF", function(value, element) {
	    if (value.length < 15){
		    value = value.replace('.','');
		    value = value.replace('.','');
		    cpf = value.replace('-','');
		    while(cpf.length < 11) cpf = "0"+ cpf;
		    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
		    var a = [];
		    var b = new Number;
		    var c = 11;
		    for (i=0; i<11; i++){
		    	a[i] = cpf.charAt(i);
		    	if (i < 9) b += (a[i] * --c);
		    }
		    if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
		    b = 0;
		    c = 11;
		    for (y=0; y<10; y++) b += (a[y] * c--);
		    if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
		    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) return false;
		    return true;
	    }else{
		    cnpj = value.replace(/\D/g,"");
		    while(cnpj.length < 14) cnpj = "0"+ cnpj;
		    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
		    var a = [];
		    var b = new Number;
		    var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
		    for (i=0; i<12; i++){
		    a[i] = cnpj.charAt(i);
		    b += a[i] * c[i+1];
		    }
		    if ((x = b % 11) < 2) { a[12] = 0; }else { a[12] = 11-x; }
		    b = 0;
		    for (y=0; y<13; y++) {
		    b += (a[y] * c[y]);
		    }
		    if ((x = b % 11) < 2) { a[13] = 0; } else { a[13] = 11-x; }
		    if ((cnpj.charAt(12) != a[12]) || (cnpj.charAt(13) != a[13]) || cnpj.match(expReg)) return false;
		    return true;
	    };
	}, "CPF ou CNPJ Inválido"); // Mensagem padr�o

	
	//mensagens personalisadas
	jQuery.extend(jQuery.validator.messages, {
	    required: "Este campo é obrigatório.",
	    remote: "Please fix this field.",
	    email: "Por favor, informe um email válido.",
	    url: "Please enter a valid URL.",
	    date: "Por favor, informe uma data válida.",
	    dateISO: "Please enter a valid date (ISO).",
	    number: "Por favor, entre um número.",
	    digits: "Por favor, entre somente dígitos.",
	    creditcard: "Please enter a valid credit card number.",
	    equalTo: "Por favor, entre o mesmo valor novamente.",
	    accept: "Extensão de arquivo não permitida.",
	    maxlength: jQuery.validator.format("Digite até {0} caracteres."),
	    minlength: jQuery.validator.format("Digite no mínimo {0} caracteres."),
	    rangelength: jQuery.validator.format("Por favor, informe um valor entre {0} e {1} caracteres."),
	    range: jQuery.validator.format("Por favor, informe um valor entre {0} e {1}."),
	    max: jQuery.validator.format("Informe um valor menor ou igual a {0}."),
	    min: jQuery.validator.format("Informe um valor maior ou igual a {0}.")
	});
	
});