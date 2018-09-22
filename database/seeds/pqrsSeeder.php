<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class pqrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $pqrs = ['Peticion','Queja','Reclamo','Sugerencia'];

    public function run()
    {
        for ($i = 0; $i < count($this->pqrs); $i++ ){
        	DB::table('tipo_pqrs')->insert([
                "nombre" => $this->pqrs[$i]
            ]);
        }
    }
}
