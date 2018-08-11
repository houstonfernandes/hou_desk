require("../jquery_validation");//@todo sem o validation na compilacao esta dando erro 20/09/17

$(function(){
    $('#panel_arquivos_enviados').hide();
    $('#progress-bar').hide();

    $("form[name=form]").submit(function(e){
        e.preventDefault();
    });

    $('#file').on('click', function(){
        $('#progress-bar').css('width', '0%').attr('aria-valuenow', 0).text("0%").hide();
        esconderAlerta();
    });
    $('#btEnviar').on('click', function(){
        upload();
    });

    $("form[name=form]").validate({
        rules: {
            file:{
                required: true,
                accept: "image/*"
            }
            //        accept: "audio/*"//accept: "image/*",//"image/*,application/pdf",//, png,jpe?g,gif,bmp,tiff,pdf",
            //filesize_mb: 100,
            //  }
        },
        messages: {}
    });

});

window.upload = function(){
    $("form[name=form]").validate();
    if(!$("form[name=form]").valid())
        return false;
	
    $('#progress-bar').show();

    let file = document.getElementById('file').files[0];
    //envia o form
    let formData = new FormData();
    formData.append("arquivo", file);
    formData.append('_token', _token);
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function (data) {
            //console.log(files);
            let file = data.file;
            let liFile = $('<li>').append(file.fileName);

            let aFileThumb = $('<img>').attr({'src':file.url_thumbnail}).css({'with':'80px', 'max-height':'400px'});//.addClass('rounded-circle');
            let aFile = $('<img>').attr({'src':file.url}).css({'with':'80px', 'max-height':'400px'});//.addClass('rounded-circle');
            liFile.append(aFileThumb);
            liFile.append(aFile);
            $('#arquivos_enviados').append(liFile);
            $('#panel_arquivos_enviados').show();
            let msg = 'Arquivo: ' + file.fileName +' enviado com sucesso.';
            exibirAlerta(msg, 'success');
            limparForm();
            //$('#progress-bar').hide();

            let files = data.document_files;
            if(files!=null){
                atualizarCheckboxArquivos(files);
            }
        },
        error: function(jqXhr) {
            let parsedJson = jqXhr.responseJSON;
            if( jqXhr.status === 500 ) {
                exibirAlerta('Erro no servidor.', 'danger');
            }
            if( jqXhr.status === 422 ) {
                //let erro = jQuery.parseJSON(data);
                let parsedJson = jqXhr.responseJSON;
//console.log(parsedJson)
                let errorString = '';
                $.each( parsedJson.errors, function( key, value) {
                    errorString += '<ul>' + key;
                    $.each( value, function( i, msg) {
                        errorString += '<li>' + msg + '</li>';
                    });
                    errorString +='</ul>';
                });
                exibirAlerta(errorString, 'danger');
            }
        },
        cache: false,
        contentType: false,
        processData: false,
        xhr: function() {  // Custom XMLHttpRequest
            let myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                myXhr.upload.addEventListener('progress', uploadProgress, false);
            }
            return myXhr;
        }
    });

    uploadProgress = function(event){
        if (event.lengthComputable) {
            let percent = Math.round(event.loaded * 100 / event.total); //cálculo simples de porcentagem.
            $('#progress-bar').css('width', percent+'%').attr('aria-valuenow', percent).text(percent+"%");
        }
    }

    limparForm = function(){
        $('#file').val(null);
        //$( '#div_alerta').empty();//.hide();
    }

    atualizarCheckboxArquivos = function(documentFiles){
//console.log('em atualizar checkbox');
//console.log(documentFiles);

        let div = $('<div class="checkbox">');
        let label = $('<label>');
        let checkbox = $('<input type="checkbox" name="arquivo_id[]">');

        let divDocumentFiles = $('#divDocumentFiles');
        divDocumentFiles.empty();
        $.each(documentFiles, function(i, arquivo){
//console.log('nome =' +arquivo.nome +arquivo.id);
            let divDoc = div.clone();
            let labelDoc = label.clone();
            let checkboxDoc = checkbox.clone().attr('value', arquivo.id);
            labelDoc.append(checkboxDoc, arquivo.nome);
            divDoc.html(labelDoc);
            divDocumentFiles.append(divDoc);
        });
    }
}
