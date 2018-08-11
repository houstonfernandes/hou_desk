<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HSF') }}</title>
    <!-- icones -->
    <link rel="icon" href="{{asset('imagens/hsf_systems.png')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{asset('imagens/hsf_systems_comercial2.png')}}" type="image/x-icon" />
    <!-- css  -->
    <link rel='stylesheet' media='all' href="{{asset('css/bootstrap_dropdown_sub.css')}}" type='text/css' />
    <link rel='stylesheet' media='all' href="{{asset('css/layout.css')}}" type='text/css' />
	<!--<link rel='stylesheet' media='all' href="{{asset('css/app.css')}}" type='text/css' />-->

    @stack('css')

    <script type="text/javascript" src="{{asset('js/manifest.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/vendor.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
</head>
<body>

    <div class="container">

        @include('layouts.menu')

        @include('partial.flash_message')
        
        @include('partial.errors')

        <div id="divMsg"></div>

        @yield('content')

    </div>

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    baseUrl = "{{asset('')}}";
    window._token ="{{ csrf_token() }}";
    //console.log('baseurl = ' +baseUrl);
    </script>

    @stack('js')

</body>
</html>