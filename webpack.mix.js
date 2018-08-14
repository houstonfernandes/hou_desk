let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
let webpack = require('webpack');

mix.webpackConfig({
    plugins:[
        new webpack.ProvidePlugin({
            $:'jquery',
            jQuery: 'jquery'
        })
    ]
});

mix.extract([
    'jquery', 'bootstrap-sass'
]);
mix.js('resources/assets/js/admin/locais_create.js', 'public/js/admin');


mix.js('resources/assets/js/admin/modal_excluir.js', 'public/js/admin');//excluir default
/*

mix.js('resources/assets/js/admin/product_images_create.js', 'public/js/admin');
mix.js('resources/assets/js/admin/clientes_create.js', 'public/js/admin');
mix.js('resources/assets/js/admin/clientes_edit.js', 'public/js/admin');
mix.js('resources/assets/js/admin/products_create.js', 'public/js/admin');
mix.js('resources/assets/js/admin/products_edit.js', 'public/js/admin');
mix.js('resources/assets/js/admin/fornecedores_create.js', 'public/js/admin');
mix.js('resources/assets/js/admin/fornecedores_edit.js', 'public/js/admin');

mix.js('resources/assets/js/admin/pedido_create_mercado.js', 'public/js/admin');
mix.js('resources/assets/js/admin/pedido_create.js', 'public/js/admin');
mix.js('resources/assets/js/admin/modal_pedido_excluir_item.js', 'public/js/admin');
mix.js('resources/assets/js/admin/modal_pedido_pesquisar_produto.js', 'public/js/admin');
mix.js('resources/assets/js/admin/modal_pedido_pagamento.js', 'public/js/admin');

*/

mix.js('resources/assets/js/admin/roles_permissions.js', 'public/js/admin');
/*
mix.js('resources/assets/js/admin/compra_create.js', 'public/js/admin');
mix.js('resources/assets/js/admin/compra_create_init.js', 'public/js/admin');
mix.js('resources/assets/js/admin/modal_compra_pesquisar_produto.js', 'public/js/admin');
mix.js('resources/assets/js/admin/modal_compra_pesquisar_fornecedor.js', 'public/js/admin');
mix.js('resources/assets/js/admin/modal_compra_excluir_item.js', 'public/js/admin');
mix.js('resources/assets/js/admin/modal_compra_editar_item.js', 'public/js/admin');
mix.js('resources/assets/js/admin/compra_edit.js', 'public/js/admin');
mix.js('resources/assets/js/admin/compra_edit_init.js', 'public/js/admin');
*/
//arquivos em js por ultimo para vendor e manifest nao ficarem na pasta admin
mix.js('resources/assets/js/app.js', 'public/js')	
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.sass('resources/assets/sass/layout.scss', 'public/css');

//LIBS
mix.js('resources/assets/js/jquery_numeric.js', 'public/js');
mix.js('resources/assets/js/jquery_validation.js', 'public/js');
mix.js('resources/assets/js/jquery_mask_plugin.js', 'public/js');

mix.copy('resources/assets/css/images', 'public/css/images')//jquery-ui css
	.copy('resources/assets/css/jquery-ui.min.css', 'public/css');
mix.js('resources/assets/js/jquery_ui.js', 'public/js');

mix.copy('resources/assets/css/bootstrap_dropdown_sub.css', 'public/css');//menu bootstrap

mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/', 'public/fonts/');//bootstrap fonts bug