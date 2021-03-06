<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'HSF Systems') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            body{
                background: url('imagens/houdeska.png');
                background-repeat: no-repeat;
                background-size: cover;
            }
        
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
     
        </style>
    <link rel='stylesheet' media='all' href="{{asset('css/layout.css')}}" type='text/css' />
        
    </head>
    <body>
        <div class="nav navbar-nav navbar-left">
            <ul class="dropdown-menu">
                 <li><a href="{{ route('admin.users.index') }}" title="Cadastro de Usuários">Cadastro de Usuários</a></li>   
                <li><a href="#" title="Cadastro de equipamentos">Cadastro de equipamentos</a></li>  
                <li><a href="#" title="Solicitação de serviço">Solicitação de serviço</a></li>  
            </ul>
        </div>    
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        {{--<a href="{{ route('register') }}">Register</a>--}}
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
	                <img src="{{asset('imagens/hsf_systems_helpdesk.png')}}" class='img-responsive' title="{{config('app.name', 'HSF Systems')}}">                    
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="houston-s-fernandes.herokuapp.com">Houston Home</a>
                    <a href="data-file.herokuapp.com">data-file</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
