$(function(){	
		$.datepicker.setDefaults({
				dateFormat: "dd/mm/yy",
				dayNames: ['Domingo','Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
				dayNamesMin: ['D','S', 'T', 'Q', 'Q', 'S', 'S'],
				dayNamesShort: ['Dom','Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
				monthNamesShort:['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
				monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
				nextText:'Próximo',
				prevText:'Anterior',
				changeMonth:true, 
				changeYear:true
		});
		//$('div.ui-datepicker').css({ 'font-size': '200.5%' });//redimensionar datepicker
		$('a.button').button().css('color','#fff');	//links de botões

    $( ".datepicker" )
        .datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy"
        });    
    
});