<?php

use Illuminate\Database\Seeder;

class mesesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    
    public function run()
    {
        for ($i = 0; $i < count($this->meses); $i++ ){
        	DB::table('meses')->insert([
                "nombre" => $this->meses[$i]
            ]);
        }
    }
}
