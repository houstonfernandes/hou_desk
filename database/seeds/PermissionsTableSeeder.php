<?php
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Permission::class)->create([
            'name' => "cad_produto",
            'label' => 'Cadastrar produto'
        ]);
        factory(App\Permission::class)->create([
            'name' => "cad_cliente",
            'label' => 'Cadastrar cliente'
        ]);
        factory(App\Permission::class)->create([
            'name' => "cad_fornecedor",
            'label' => 'Cadastrar fornecedor'
        ]);
        factory(App\Permission::class)->create([
            'name' => "cad_usuario",
            'label' => 'Cadastrar usuário'
        ]);
        factory(App\Permission::class)->create([
            'name' => "faz_compra",
            'label' => 'Fazer compra'
        ]);
        factory(App\Permission::class)->create([
            'name' => "faz_venda",
            'label' => 'Fazer venda'
        ]);
        factory(App\Permission::class)->create([
            'name' => "faz_estoque",
            'label' => 'Fazer estoque'            
        ]);
        factory(App\Permission::class)->create([
            'name' => "faz_devolucao",
            'label' => 'Fazer devolucao'
        ]);
        factory(App\Permission::class)->create([
            'name' => "rel_estoque_compra",
            'label' => 'Relatório estoque compras'
        ]);
        factory(App\Permission::class)->create([
            'name' => "rel_estoque_venda",
            'label' => 'Relatório estoque vendas'
        ]);
        factory(App\Permission::class)->create([
            'name' => "rel_estoque_ajuste",
            'label' => 'Relatório estoque ajustes'
        ]);
        factory(App\Permission::class)->create([
            'name' => "rel_estoque_baixo",
            'label' => 'Relatório estoque baixo'
        ]);
        factory(App\Permission::class)->create([
            'name' => "rel_venda_devolucao",
            'label' => 'Relatório venda devolução'
        ]);
        factory(App\Permission::class)->create([
            'name' => "rel_venda_vendedor",
            'label' => 'Relatório vendas vendedor'
        ]);
        factory(App\Permission::class)->create([
            'name' => "rel_venda_produto",
            'label' => 'Relatório vendas produto'
        ]);
        factory(App\Permission::class)->create([
            'name' => "rel_movimentacao",
            'label' => 'Relatório movimentação'
        ]);
        
        factory(App\Permission::class)->create([
                'name' => "show_admin_options",
                'label' => 'Mostrar opções administrativas no menu'
            ]
        );
        factory(App\Permission::class)->create([
                'name' => "cad_user_role",
                'label' => 'Cadastrar papéis de Usuários'
            ]);
        factory(App\Permission::class)->create([
                'name' => "cad_role",
                'label' => 'Cadastrar papéis'
            ]
        );
        factory(App\Permission::class)->create([
                'name' => "cad_role_permission",
                'label' => 'Cadastrar Permissões de Papel'
            ]
        );

    }
}