<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class casasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 60; $i++){
        	DB::table('casas')->insert([
                "nombre" => 'Casa '."$i"
            ]);
        }
    }
}
