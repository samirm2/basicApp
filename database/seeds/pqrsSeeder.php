<?php

use Illuminate\Database\Seeder;

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
        	$ob = new \App\TipoPqrs();
        	$ob->nombre = $this->pqrs[$i];
        	$ob->save();
        }
    }
}
