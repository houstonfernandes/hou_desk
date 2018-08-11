<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('users')->truncate();
/*        factory(Hsf\Role::class)->create([
                'name' => "admin",
                'label' => 'Administrador'
            ]
        );
*/
        factory(App\Role::class)->create([
                'name' => "supervisor",
                'label' => 'Supervisor'
            ]
        );
        factory(App\Role::class)->create([
                'name' => "usuario",
                'label' => 'Usuário'
            ]
        );
        factory(App\Role::class)->create([
            'name' => "tecnico",
            'label' => 'Técnico'
        ]
            );
        
     //   factory(Hsf\Role::class, 9)->create();
    }
}
