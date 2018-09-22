<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class rolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $roles = ['Administrador', 'Propietario', 'Arrendatario'];

    public function run()
    {
        for ($i = 0; $i < count($this->roles); $i++ ){
        	DB::table('roles')->insert([
                "nombre" => $this->roles[$i]
            ]);
        }
    }
}
