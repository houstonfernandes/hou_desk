<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HSF') }}</title>
    <!-- icones -->
    <link rel="icon" href="{{asset('imagens/hsf_systems_helpdesk.png')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{asset('imagens/hsf_systems_helpdesk.png')}}" type="image/x-icon" />
    <!-- css  -->
    <link rel='stylesheet' media='all' href="{{asset('css/bootstrap_dropdown_sub.css')}}" type='text/css' />
    <link rel='stylesheet' media='all' href="{{asset('css/layout.css')}}" type='text/css' />
	<!--<link rel='stylesheet' media='all' href="{{asset('css/app.css')}}" type='text/css' />-->

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            body{
                background: url('imagens/houdeska.png');
                background-repeat: no-repeat;
                background-size: cover;
                background-color: #000;
                font-family: 'Raleway', sans-serif;
                color: #fff;
                font-weight: 100;
            }            
            .title {
                font-size: 90px;
                font-weight:bold;
            }
            .subtitle {
                /*font-family:  tahoma, serif;*/
                font-size: 18px;
                font-weight:bold;
            }
            a{
                margin-top:20px;
            }
            #title{
                margin-top: 20%;
                
            }
        </style>
    </head>





<body>

    <div class="container">
        <div class="row">
            <div id='title' class="col-md-8 col-md-offset-4">
                	<div class='title'>{{config('app.name', 'HSF Systems')}}</div>
                	<div class='subtitle'>Uma solução para gerenciar atendimento de serviços</div>

                    @if (Route::has('login'))
                        <div class="top-right links">
                            @auth
                            <div class='col-md-4 col-md-offset-3'>
                            	<a  class='btn btn-primary' href="{{ route('home') }}">Home</a>
                            </div>
                            @else
	                	<div class='col-md-4 col-md-offset-3'>
    	            		<a  class='btn btn-primary' href="{{ route('login') }}">Login</a>
                    	</div>
                            @endauth
                        </div>
                    @endif
                	
                	
            </div>
        </div>
	</div>


</body>
</html>


