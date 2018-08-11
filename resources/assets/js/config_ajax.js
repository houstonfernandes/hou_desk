/*var imagemErro ="<img src='"  + baseUrl + "/imagens/erro.png' width='30' height='30'/> ";
var imagemAlerta ="<img src='"  + baseUrl + "/imagens/exclamacao.png' width='30' height='30'/> ";
var imagemSucesso ="<img src='"  + baseUrl + "/imagens/accept.png' width='30' height='30'/> ";
var imagemCarregando ="<img src='"  + baseUrl + "/imagens/loading.gif' width='30' height='30'/> ";
var divAjaxStatus = $('<div id=ajaxStatus>');
*/
window.exibirAlerta = function (msg, classe)
{
//    console.log('em exibir alerta class=' +classe);
    var msgString = '<div role="alert" class="alert alert-' + classe + '" ><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    msgString += msg;
    $( '#divMsg').html(msgString).show();

}

window.esconderAlerta = function()
{
    $( '#divMsg').hide();
}


$(document).ready(
function(){
		$.ajaxSetup({
			type:'post',
			dataType:'json',
			error: function(jqXhr) {
				var parsedJson = jqXhr.responseJSON;
				if( jqXhr.status === 500 ) {
					exibirAlerta('Erro no servidor.', 'danger');
				}
				if( jqXhr.status === 422 ) {
					var parsedJson = jqXhr.responseJSON;
//console.log(parsedJson)
					var errorString = '';
					$.each( parsedJson, function( key, value) {
						errorString += '<ul>' + key;
						$.each( value, function( i, msg) {
							errorString += '<li>' + msg + '</li>';
						});
						errorString +='</ul>';
					});
					exibirAlerta(errorString, 'danger');
				}
			},

/*			error: function(xhr, er){
				$('<p>').prop({'class':'erro', 'title':'Erro'}).html(imagemErro+" Houve falha ao se comunicar com o servidor.<br>erro :"+xhr.status+" "+xhr.statusText)
					.dialog(
					{	buttons:{'ok': function() {
							$( this ).dialog( "close" );}
						}
					}
				);
			}*/
		});
		/*
		$(document).ajaxStart(function(){
			divAjaxStatus.html(imagemCarregando + ' Carregando.').dialog();
		}).ajaxStop(function(){
			divAjaxStatus.dialog('close');				
		});
		
		
		$.sucesso = function(msg){
			$('<p>').prop({'title':'Sucesso'}).html(imagemSucesso+msg)
				.dialog(
				{	buttons:{'ok': function() {
						$( this ).dialog( "close" );}
					}
				}
			);
		};
		$.erro = function(msg){
			$('<p>').prop({'title':'Erro'}).html(imagemErro+msg)
				.dialog(
				{	buttons:{'ok': function() {
						$( this ).dialog( "close" );}
					}
				}
			);
		};
		
		$.msg = function(msg,title){
			$('<p>').prop({'title':title}).html(msg)
				.dialog(
				{	buttons:{'ok': function() {
						$( this ).dialog( "close" );}
					}
				}
			);
		};
		*/
		
	}
);