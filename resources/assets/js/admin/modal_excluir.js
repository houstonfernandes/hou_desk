/**
 * Created by houston on 22/03/18.
 * @param name
 * @param msg
 * @param msg_alert
 */

$('#modal-excluir').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    $(this).find('#bt-confirmar-excluir').data('url',button.data('url'));
    $(this).find('.modal-body').html(button.data('msg') + " <strong>" + button.data('name') + "</strong>" +
        "<p class='warning'>" + button.data('msg_alert') +  "</p>" );
});

$('#bt-confirmar-excluir').on('click', function(){
    excluir($(this).data('url'));
});

window.excluir = function(url){
    $('form[name=form-modal-excluir]').prop('action',url)
        .submit();
}
