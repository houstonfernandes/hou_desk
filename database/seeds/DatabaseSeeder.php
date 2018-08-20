<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocalTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TipoEquipamentoTableSeeder::class);
        $this->call(TipoServicoTableSeeder::class);
        $this->call(SetorTableSeeder::class);
        $this->call(EquipamentoTableSeeder::class);
        $this->call(ComponenteTableSeeder::class);
        
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
    }
}
