<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class propietariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $gender = ['male','female'];
    private $genero = ['Masculino','Femenino'];

    public function run()
    {
        $faker = Faker\Factory::create('es_ES');
        //creo 60 propietarios con faker
        for( $i = 0; $i < 60; $i++){
            $generoId = rand(0,1);    
            
            $personaId = DB::table('personas')->insertGetId([
                'cedula'=> rand(9999999,99999999),
                'nombres'=> $faker->firstName($this->gender[$generoId]),
                'apellidos'=> $faker->lastName($this->gender[$generoId]),
                'sexo' => $this->genero[$generoId],
                'telefono'=> $faker->phoneNumber,
                'email'=> $faker->freeEmail
            ]);
        
            DB::table('users')->insert([
                'name'=> $faker->userName,
                'password'=>Hash::make('ziruma1'),
                'rol'=>'Propietario',
                'persona_id'=> $personaId
            ]);

            $propietarioId = DB::table('propietarios')->insertGetId([
                'persona_id'=> $personaId
            ]);

            DB::table('casas')
            ->where('id' , $i+1)
            ->update([
                'propietario_id'=> $propietarioId
            ]);
            
            
        }
    }
}
