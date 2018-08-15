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
        // $this->call(UsersTableSeeder::class);
        $this->call(rolesSeeder::class);
        $this->call(casasSeeder::class);
        $this->call(pqrsSeeder::class);
        $this->call(mesesSeeder::class);
        $this->call(AdministradorSeeder::class);
        $this->call(propietariosSeeder::class);
    }
}
