@extends('layouts.template')<!DOCTYPE html>

@section('css')
    <link rel="stylesheet" href="{{asset('css/jquery.fileupload.css')}}">
@endsection

@section('content')
    <form id="uploadForm" action="" enctype="multipart/form-data" method="post" name="form">
        <div class ='form-group'>
            <input id="file" type="file" name="file" class="form-control" required/>
        </div>

        <div class ='form-group'>
            <label for="descricao">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição do arquivo" required>
        </div>

        <div class ='form-group'>
            <label for="arquivo_id">Arquivo relacionado</label>
            <select class="form-control" name="arquivo_id" id="arquivo_id">
                <option value="" disabled selected hidden>Selecione se tiver for relacionado</option>
            </select>
        </div>

        <div class ='form-group'>
            <input onclick="javascript:upload();" type="button" value="Enviar" class="form-control"/>
        </div>


    </form>

    <br>

    <div class="progress">
        <div class="progress-bar progress-bar-primary" id='progress-bar'  role="progressbar" aria-valuenow="0"
             aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
            0%
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{asset('js/jquery.validate.js')}}"></script>
    <script>
        var request = new XMLHttpRequest();

        $('form').submit(function(e){
            e.preventDefault();
        });

        var url = "{{route('teste.storage')}}";
        $('#file').on('click', function(){
            $('#progress-bar').css('width', '0%').attr('aria-valuenow', 0).text("0%");
        });

        function upload() {
            $("form[name=form]").validate();
            console.log('validou=' + $("form[name=form]").valid())
            if(!$("form[name=form]").valid()) return false;

            var descricao = document.getElementById('descricao').value;
            var arquivo_id = document.getElementById('arquivo_id').value;
            var file = document.getElementById('file').files[0];

            var request = new XMLHttpRequest();
            request.upload.addEventListener("progress", uploadProgress, false);
            request.addEventListener("error", funcaoTrataErro, false);
            request.addEventListener("load", transferComplete, false);

            //envia o form
            var formData = new FormData();
            formData.append('descricao', descricao);
            formData.append('arquivo_id', arquivo_id);
            formData.append("file", file);
            formData.append('_token', "{{ csrf_token() }}");

            request.open("POST", url);
            request.send(formData);
        }

        function uploadProgress(event) {
            if (event.lengthComputable) {
                var percent = Math.round(event.loaded * 100 / event.total); //cálculo simples de porcentagem.
                $('#progress-bar').css('width', percent+'%').attr('aria-valuenow', percent).text(percent+"%");
            } else {
                //não é possível computar o progresso =/
            }
        }

        function transferComplete(event) {
console.log(event);
            $('#descricao').val('');
            $('#file').val(null);
console.log("A transferência foi concluída.\n" + response);

        }

        function funcaoTrataErro(event) {
            alert("Erro ao efetuar upload do arquivo!");
        }

        $("form[name=form]").validate({
            rules: {
                descricao:{required: true},
                "file":{required:true}
            },
            messages: {}
        });

    </script>
@endpush
