$(function(){
	let situacao;	
	$('[name=situacao], [name=solucao]').on('focus',function(){
		$("#erro_atender").empty();		
	});
	
	$('[name=situacao]').on('change',function(){
		 situacao = $(this).val();
		if(situacao == ''){
			$('[name=solucao]').val('');
			return false;
		}
	});	
	
	$('form[name=form_atendimento]').on('submit',function(e){
		if($('[name=situacao]').val() == 5){
			let solucao = $('[name=solucao]').val();
console.log(solucao);			
			if(solucao.length < 5){
				let msg = 'Campo solução deve ser informado, com mais de 5 caracteres.';
				var msgString = `<div role="alert" class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
										&times;
									</button>
									${msg}
								</div>`;
				
				$("#erro_atender").html(msgString);
				e.preventDefault();
			}
		}		
	});
	
});
