# HOU_DESK - helpdesk utilizando Laravel 5.6 
Houston S. Fernandes - houstonsf.sys@gmail.com

## em fase inicial 28/08/18
	18/09/2018 - implementando Serviços
	
## casos de uso, mer e instalacão em: app/docs


## requisitos:
	> php 7.2, composer, banco:configurar .env(usado mysql)
	
## INSTALACAO SISTEMA HOU DESK:
	1 - clonar repositorio
		$ git clone ~/repositorios/hou_desk
		(web) $ git clone https://github.com/houstonfernandes/hou_desk.git

	2 - selecionar dir
	$ cd hou_desk/

	3 - instalar dependencias
		$composer install 
		//** se estiver desenvolvendo instalar dependencias de npm: $npm install

	4 - criar banco
		$ mysql -u root -p

		$mysql>
			CREATE DATABASE hou_desk DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
		# criar usuario a atribuir permissoes
			CREATE USER 'hou_desk_user'@'localhost' IDENTIFIED BY 'hou-desk'; GRANT ALL PRIVILEGES ON hou_desk.* TO 'hou_desk_user'@'localhost' WITH GRANT OPTION; 

	5 - criar .env
		$ cp .env.example .env

	6 - gerar app key
		$ php artisan key:generate
	
	7 -editar configuracoes do banco em .env
	
	8 - configurar servidor de email e adicionar no .env
		MAIL_FROM_ADDRESS="emailorigem@email.com"
		MAIL_FROM_NAME="HOU_DESK Help Desk que sera exibido"	
	
	9 - criar tabelas do banco e popular
		$ php artisan migrate
		$php artisan db:seed
	
	10 - testar
		$ php artisan serve


  
  
<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
