<?php

use Illuminate\Database\Seeder;

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
        	$ob = new \App\casa();
        	$ob->nombre = 'Casa '."$i";
        	$ob->save();
        }
    }
}
