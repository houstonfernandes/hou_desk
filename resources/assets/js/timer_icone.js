/**
 * @author Houston S. Fernandes
 * uso: <span class='timericone' data-dataHora="{{$servico->created_at}}" data-tempo_limite="6">ok</span>
 */
let moment = require('moment');
let segundos = 10;
$(function(){
	timerIcone();
	setInterval(timerIcone, segundos * 1000);	
});

  timerIcone = function() {
//console.log('atualizando timericone');
      $('.timericone').each(function() {
    	let dataHora = $(this).data('data_hora');
    	let limite = $(this).data('tempo_limite');
    	let quaseLimite = limite *.8;//80% dolimite
    	let dataHoraLimite = moment(dataHora).add(limite, 'm').toDate();  
    	let dataHoraQuaseLimite = moment(dataHora).add(quaseLimite, 'm').toDate();
    	
//    	console.log(dataHora + ' ====== ' + dataHoraLimite);	
     
        let antes = moment().isBefore(dataHoraQuaseLimite); // verifica se é antes do limite
        let quase = moment().isAfter(dataHoraQuaseLimite) && moment().isBefore(dataHoraLimite);        

//        console.log('quase='+quase);
        
        if(antes){
        	$(this).css('color', 'green');//.text('adiantado');
        }
        else if(quase){
        	$(this).css('color', 'yellow');//.text('atenção');
        	//$(this).prop('class', 'text-danger')
        }
        else{
        	$(this).css('color', 'red');//.text('atrasado');
        }
      });
  };
