<?php

use Illuminate\Database\Seeder;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $persona = new \App\Persona();
        $persona->cedula = '1234567890';
        $persona->nombres = 'Juan Camilo';
        $persona->apellidos = 'Osorio Mendoza';
        $persona->sexo = 'Masculino';
        //$persona->fecha_nacimiento = '1994/08/18';
        $persona->telefono = '3005456578';
        $persona->email = 'admin@admin.co';
        $persona->save();
        $usuario = new \App\User();
        $usuario->name = 'admin';
        $usuario->password = Hash::make('admin');
        $usuario->rol = 'Administrador';
        $usuario->persona_id = $persona->id;
        $usuario->save();
    }
}
