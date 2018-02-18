<?php

use Illuminate\Database\Seeder;

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
        	$ob = new \App\Rol();
        	$ob->nombre = $this->roles[$i];
        	$ob->save();
        }
    }
}
