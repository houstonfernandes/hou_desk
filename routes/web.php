<?php
/*
| Web Routes
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

//*** SEM AUTH
Route::get('/', function () {
    return view('index');
})->name('/');
Route::pattern('id','[0-9]+');

//***** API SEM AUTH
Route::prefix('api')
    ->name('api.')
    ->group(function(){
    Route::get('locais/listar_setores/{id}', ['as' => 'locais.listar_setores', 'uses' => 'LocaisController@listarSetores']);//json
        
    Route::get('equipamentos/listar_local/{id}', ['as' => 'equipamento.listar_local', 'uses' => 'EquipamentosController@listarLocal']);//json
    Route::get('equipamentos/listar_setor/{id}', ['as' => 'equipamento.listar_setor', 'uses' => 'EquipamentosController@listarSetor']);//json
        
    Route::post('users/get_permissions', ['as' => 'users.get_permissions', 'uses' => 'UsersController@getPermissions']);//json    
});
    
//*** AUTH
Route::group(['prefix' => 'users', 'middleware'=>'auth', 'as' => 'users.'], function () {
    Route::get('edit_own', ['as' => 'edit_own', 'uses' => 'UsersController@editOwn']);
    Route::put('/{id}', ['as' => 'update_own', 'uses' => 'UsersController@updateOwn']);//usar attr hidden name=_method value=PUT
});

Route::group(['prefix' => 'servicos', 'middleware'=>'auth', 'as' => 'servicos.'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'ServicosController@index']);
    Route::get('create', ['as' => 'create', 'uses' => 'ServicosController@create']);
    Route::post('/', ['as' => 'store', 'uses' => 'ServicosController@store']);
    Route::get('consultar/{id}', ['as' => 'consultar', 'uses' => 'ServicosController@consultar']);
    Route::post('store_mensagem', ['as' => 'store_mensagem', 'uses' => 'ServicosController@storeMensagem']);
    Route::put('atender', ['as' => 'atender', 'uses' => 'ServicosController@atender']);
    
    //Route::get('/{id}', ['as' => 'update_own', 'uses' => 'UsersController@updateOwn']);//usar attr hidden name=_method value=PUT
});

Route::group(['prefix' => 'relatorios', 'middleware'=>'auth', 'as' => 'relatorios.'], function () {
    Route::get('/', ['as' => 'equipamentos_descritivo', 'uses' => 'RelatoriosController@equipamentosDescritivo']);
    Route::post('/', ['as' => 'equipamentos_descritivo', 'uses' => 'RelatoriosController@equipamentosDescritivo']);
    Route::get('equipamentos_quantitativo', ['as' => 'equipamentos_quantitativo', 'uses' => 'RelatoriosController@equipamentosQuantitativo']);
    Route::post('equipamentos_quantitativo', ['as' => 'equipamentos_quantitativo', 'uses' => 'RelatoriosController@equipamentosQuantitativo']);    
    Route::get('servicos_quantitativo', ['as' => 'servicos_quantitativo', 'uses' => 'RelatoriosController@servicosQuantitativo']);
    Route::post('servicos_quantitativo', ['as' => 'servicos_quantitativo', 'uses' => 'RelatoriosController@servicosQuantitativo']);    
});
        

// **** ADMIN
Route::prefix('admin/users')
    ->name('admin.users.')
    ->middleware('auth')
    ->group(function(){
        Route::get('/', ['as' => 'index', 'uses' => 'UsersController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'UsersController@create']);
        Route::post('/', ['as' => 'store', 'uses' => 'UsersController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'UsersController@edit']);
        Route::put('/{id}', ['as' => 'update', 'uses' => 'UsersController@update']);//usar attr hidden name=_method value=PUT
        Route::delete('/{id}', ['as' => 'delete', 'uses' => 'UsersController@delete']);
        Route::get('{id}/roles', ['as' => 'roles', 'uses' => 'UsersController@roles']);
        Route::put('{id}/roles', ['as' => 'roles', 'uses' => 'UsersController@rolesUpdate']);
    });

Route::prefix('admin/tipos_servico')
    ->name('admin.tipos_servico.')
    ->middleware('auth')
    ->group(function(){
        Route::get('/', ['as' => 'index', 'uses' => 'TipoServicoController@index']);
        Route::post('/', ['as' => 'store', 'uses' => 'TipoServicoController@store']);
        Route::get('create', ['as' => 'create', 'uses' => 'TipoServicoController@create']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'TipoServicoController@edit']);
        Route::put('/{id}', ['as' => 'update', 'uses' => 'TipoServicoController@update']);
        Route::delete('/{id}', ['as' => 'delete', 'uses' => 'TipoServicoController@delete']);
    });
            
    
    
Route::prefix('admin/tipos_equipamento')
        ->name('admin.tipos_equipamento.')
        ->middleware('auth')
        ->group(function(){
            Route::get('/', ['as' => 'index', 'uses' => 'TipoEquipamentoController@index']);
            Route::post('/', ['as' => 'store', 'uses' => 'TipoEquipamentoController@store']);
            Route::get('create', ['as' => 'create', 'uses' => 'TipoEquipamentoController@create']);
            Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'TipoEquipamentoController@edit']);
            Route::put('/{id}', ['as' => 'update', 'uses' => 'TipoEquipamentoController@update']);
            Route::delete('/{id}', ['as' => 'delete', 'uses' => 'TipoEquipamentoController@delete']);
        });
            

Route::prefix('admin/locais')
    ->name('admin.locais.')
    ->middleware('auth')
    ->group(function(){
        Route::get('/', ['as' => 'index', 'uses' => 'LocaisController@index']);
        Route::post('/', ['as' => 'store', 'uses' => 'LocaisController@store']);
        Route::get('create', ['as' => 'create', 'uses' => 'LocaisController@create']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'LocaisController@edit']);
        Route::put('/{id}', ['as' => 'update', 'uses' => 'LocaisController@update']);
        Route::delete('/{id}', ['as' => 'delete', 'uses' => 'LocaisController@delete']);
    });
    
Route::prefix('admin/setores')
    ->middleware('auth')
    ->name('admin.setores.')
    ->group(function(){
        Route::get('{id}/', ['as' => 'index', 'uses' => 'SetoresController@index']);//setores do local
        Route::post('/', ['as' => 'store', 'uses' => 'SetoresController@store']);
        Route::get('{id}/create', ['as' => 'create', 'uses' => 'SetoresController@create']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'SetoresController@edit']);
        Route::put('/{id}', ['as' => 'update', 'uses' => 'SetoresController@update']);
        Route::delete('/{id}/{local_id}', ['as' => 'delete', 'uses' => 'SetoresController@delete']);
    });

Route::prefix('admin/equipamentos')
    ->middleware('auth')
    ->name('admin.equipamentos.')
    ->group(function(){
        Route::get('{id}/', ['as' => 'index', 'uses' => 'EquipamentosController@index']);//equipamentos do local       
//        Route::get('{id?}/', ['as' => 'index', 'uses' => 'EquipamentosController@index']);//equipamentos do local se nao informar lista todos
        Route::get('{id}/create', ['as' => 'create', 'uses' => 'EquipamentosController@create']);
        Route::post('/', ['as' => 'store', 'uses' => 'EquipamentosController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'EquipamentosController@edit']);
        Route::put('/{id}', ['as' => 'update', 'uses' => 'EquipamentosController@update']);
        Route::delete('/{id}', ['as' => 'delete', 'uses' => 'EquipamentosController@delete']);
    });

Route::prefix('admin/roles')
    ->name('admin.roles.')
    ->middleware('auth')
    ->group(function(){
    Route::get('/', ['as' => 'index', 'uses' => 'RolesController@index']);
    Route::post('/', ['as' => 'store', 'uses' => 'RolesController@store']);
    Route::put('/{id}', ['as' => 'update', 'uses' => 'RolesController@update']);
    Route::delete('/{id}', ['as' => 'delete', 'uses' => 'RolesController@delete']);
    Route::get('create', ['as' => 'create', 'uses' => 'RolesController@create']);
    Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'RolesController@edit']);
    Route::get('{id}/permissions', ['as' => 'permissions', 'uses' => 'RolesController@permissions']);
    Route::put('{id}/permissions', ['as' => 'permissions', 'uses' => 'RolesController@permissionsUpdate']);
});
    
//****** TESTES ********
Route::get('/evento', function () {//rota para testar evento pedido
    $pedido = App\Pedido::find(40);
    event(new App\Events\PedidoCriado($pedido));
});
        
        
Route::group(['prefix' => 'acl', 'as' => 'acl.','middleware'=>'auth'], function () {
    Route::get('permissions',['as' =>'permissions', 'uses'=> 'AclController@permissoes']);
    Route::get('teste', ['as'=>'teste', 'uses'=>'AclController@testeAcl']);
    Route::get('todas_permissions', ['as'=>'todas_permissions', 'uses'=>'AclController@todasPermissoesSistema']);
    Route::get('todas_permissions_todos_users', ['as'=>'todas_permissions_todos_users', 'uses'=>'AclController@todasPermissoesSistemaTodosUsers']);
    Route::get('roles_permissions', ['as'=>'roles_permissions', 'uses'=>'AclController@rolesPermissions']);
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
