@if ($errors->any())
    <div class="alert alert-danger" role="alert"  id="div_alerta">
        <ul>
            @foreach ( $errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @else
    <div id="div_alerta" hidden></div>
@endif
