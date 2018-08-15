<?php
/*
| Web Routes
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

//*** SEM AUTH
Route::get('/', function () {
    return view('welcome');
})->name('/');
Route::pattern('id','[0-9]+');

//***** API SEM AUTH
Route::prefix('api')
    ->name('api.')
    ->group(function(){
    Route::get('products/cod_barra/{id}', ['as' => 'produto.consultar.cod_barra', 'uses' => 'ProductsController@consultarCodBarra']);//json
    Route::get('products/consultar/{id}', ['as' => 'produto.consultar.id', 'uses' => 'ProductsController@consultarId']);//json
    Route::post('products/search/', ['as' => 'products.search', 'uses' => 'ProductsController@search']);//json
    Route::post('fornecedores/search/', ['as' => 'fornecedores.search', 'uses' => 'FornecedoresController@search']);//json
    Route::get('categories/list', ['as' => 'categories.list', 'uses' => 'CategoriesController@list']);//json
    
    Route::post('pedidos/store/', ['as' => 'pedidos.store', 'uses' => 'PedidosController@store']);//json
    
    Route::post('users/get_permissions', ['as' => 'users.get_permissions', 'uses' => 'UsersController@getPermissions']);//json    
});
    
//*** AUTH
Route::group(['prefix' => 'users', 'middleware'=>'auth', 'as' => 'users.'], function () {
    Route::get('edit_own', ['as' => 'edit_own', 'uses' => 'UsersController@editOwn']);
    Route::put('/{id}', ['as' => 'update_own', 'uses' => 'UsersController@updateOwn']);//usar attr hidden name=_method value=PUT
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
        
Route::prefix('admin/categories')
    ->name('admin.categories.')
    ->middleware('auth')
    ->group(function(){
        Route::get('/', ['as' => 'index', 'uses' => 'CategoriesController@index']);
        Route::post('/', ['as' => 'store', 'uses' => 'CategoriesController@store']);
        Route::get('create', ['as' => 'create', 'uses' => 'CategoriesController@create']);//->name('create');
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CategoriesController@edit']);
        Route::put('/{id}', ['as' => 'update', 'uses' => 'CategoriesController@update']);
        Route::delete('/{id}', ['as' => 'delete', 'uses' => 'CategoriesController@delete']);        
    });
        
Route::prefix('admin/products')
    ->name('admin.products.')
    ->middleware('auth')
    ->group(function(){
        Route::get('/', ['as' => 'index', 'uses' => 'ProductsController@index']);
        Route::post('/', ['as' => 'store', 'uses' => 'ProductsController@store']);
        Route::get('create', ['as' => 'create', 'uses' => 'ProductsController@create']);//->name('create');
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ProductsController@edit']);
        Route::put('/{id}', ['as' => 'update', 'uses' => 'ProductsController@update']);
        Route::delete('/{id}', ['as' => 'delete', 'uses' => 'ProductsController@delete']);        
    });
        
Route::prefix('admin/product_images')
    ->name('admin.product_images.')
    ->middleware('auth')
    ->group(function(){
        Route::get('/{id}', ['as' => 'index', 'uses' => 'ProductsController@images']);
        Route::get('{id}/create', ['as' => 'create', 'uses' => 'ProductsController@createImage']);//->name('create');
        Route::post('/{id}', ['as' => 'store', 'uses' => 'ProductsController@storeImage']);
        Route::delete('/{id}/{product_id}', ['as' => 'delete', 'uses' => 'ProductsController@deleteImage']);
    });
            
Route::prefix('admin/clientes')
    ->name('admin.clientes.')
    ->middleware('auth')
    ->group(function(){
        Route::get('/', ['as' => 'index', 'uses' => 'ClientesController@index']);
        Route::post('/', ['as' => 'store', 'uses' => 'ClientesController@store']);
        Route::get('create', ['as' => 'create', 'uses' => 'ClientesController@create']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ClientesController@edit']);
        Route::put('/{id}', ['as' => 'update', 'uses' => 'ClientesController@update']);
        Route::delete('/{id}', ['as' => 'delete', 'uses' => 'ClientesController@delete']);
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
        Route::get('create', ['as' => 'create', 'uses' => 'SetoresController@create']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'SetoresController@edit']);
        Route::put('/{id}', ['as' => 'update', 'uses' => 'SetoresController@update']);
        Route::delete('/{id}', ['as' => 'delete', 'uses' => 'SetoresController@delete']);
    });
    
Route::prefix('admin/compras')
    ->middleware('auth')
    ->name('admin.compras.')
    ->group(function(){
        Route::get('/', ['as' => 'index', 'uses' => 'ComprasController@index']);
        Route::post('/', ['as' => 'store', 'uses' => 'ComprasController@store']);
        Route::put('/{id}', ['as' => 'store', 'uses' => 'ComprasController@update']);
        Route::get('create', ['as' => 'create', 'uses' => 'ComprasController@create']);//->name('create');
        Route::get('consultar/{id}', ['as' => 'consultar', 'uses' => 'ComprasController@consultar']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ComprasController@edit']);//->name('create');
        Route::get('edit_vue/{id}', ['as' => 'edit_vue', 'uses' => 'ComprasController@edit_vue']);//->name('create');
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
