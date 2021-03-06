{{--
<button type="button" class="btn btn-default" style='position:absolute; top:1;left:10;' data-toggle="collapse" data-target="#menuPrincipal">
    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
</button>
--}}
<nav class="navbar navbar-default" id='menuPrincipal'>
  <div class="container-fluid">
      <div class="navbar-header">
    	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
    		<span class="sr-only">Menu</span>
    		<span class="icon-bar"></span>
    		<span class="icon-bar"></span>
    		<span class="icon-bar"></span>
    	</button>
    	<a class="navbar-brand" href="{{route('/')}}">
        <!--{{config("app.name")}}-->
            <img src="{{asset('imagens/hsf_systems_helpdesk_menu.png')}}" alt="">
        </a>
       </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

        @if(!Auth::user())
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{route('login')}}">Login</a></li>
            </ul>
    	@else
            <ul class="nav navbar-nav">
            @can('show_admin_options')
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin<b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
    <!--
                        <li>
                            <a href="#" >opção</a>
                        </li>
                        -->
                        <li class="dropdown-submenu">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cadastros</a>
                            <ul class="dropdown-menu">
                            
	                           <li><a href="{{ route('admin.locais.index') }}" title="Cadastro de Locais">Locais</a></li>
	                           <li><a href="{{ route('admin.tipos_equipamento.index') }}" title="Cadastro de Tipos de equipamento">Tipos Equipamento</a></li>
	                           <li><a href="{{ route('admin.tipos_servico.index') }}" title="Cadastro de Tipos de serviço">Tipos de Serviço</a></li>
	                           <li><a href="{{ route('admin.users.index') }}" title="Cadastro de Usuários">Usuários</a></li>
	                           @can('user_role')
	                           @endcan
                        <li class="dropdown-submenu">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">ACL</a>
                            <ul class="dropdown-menu">
	                           @can('role_create')
	                           @endcan
	                           <li><a href="{{ route('admin.roles.index') }}" title="Cadastro de Papéis">Cadastro de Papéis</a></li>
	                           
                            </ul>
                        </li>


	                           
                            </ul>
                        </li>
                        {{--
                        <li class="dropdown-submenu">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pedidos</a>
                            <ul class="dropdown-menu">
                                 <li><a href="{{ route('admin.pedidos.index') }}" title="Pedidos">Pedidos</a></li>   
                            </ul>
                        </li>                        

                        <li class="dropdown-submenu">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Compras</a>
                            <ul class="dropdown-menu">
                                 <li><a href="{{ route('admin.compras.index') }}" title="Pedidos">Compras</a></li>
                            </ul>
                        </li>
--}}                                                
                        <li class="dropdown-submenu">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">ACL teste</a>
                            <ul class="dropdown-menu">
                                <li><a href="" title="Papéis e permissoes">Papéis e permissões</a></li>
                                <li>
                                    <a href="">Permissões do sistema</a>
                                </li>
                                <li>
                                    <a href="">Permissões do sistema de todos Usuários</a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a href="#">Log</a>
                        </li>
                    </ul>

                </li>
                @endcan

                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultas<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{route('servicos.index')}}">Serviços</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Relatórios<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{route('relatorios.equipamentos_descritivo')}}">Equipamentos descritivo</a>
                        </li>
                        <li>
                            <a href="{{route('relatorios.equipamentos_quantitativo')}}">Equipamentos quantitativo</a>
                        </li>
                        
                    </ul>
                </li>
{{--
                <li>
                    <a href="">Uploads</a>
                </li>
                <li>
                    <a href="">permissions</a>
                </li>
                <li>
                    <a href="">teste acl</a>
                </li>
--}}                
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown userdata">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-user"></span>
                        {{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{route('users.edit_own')}}">Alterar dados</a>
                        </li>
                        <li>
                            <a href=""
                               onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                                Sair
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>

			                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

       @endif 
    </div>
    </div><!-- /.container-fluid -->
</nav>    