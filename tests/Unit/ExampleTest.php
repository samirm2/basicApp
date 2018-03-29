<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testRegistrarPropietarioUnico(){
    	#dueño de la casa 8;
    	$persona = new \App\Persona();
    	$persona->cedula = '1234567890';
    	$persona->nombres = 'Alvaro jose';
    	$persona->apellidos = 'Mendoza Lopez';
    	$persona->sexo = 'Masculino';
    	$persona->fecha_nacimiento = '1994/08/18';
    	$persona->telefono = '3005333455';
    	$persona->email = 'ajmendoza@unicesar.edu.co';
    	$this->assertTrue($persona->save());
    	$usuario = new \App\User();
    	$usuario->name = 'ajmendoza';
    	$usuario->password = Hash::make('secret');
    	$usuario->rol = 'Propietario';
    	$usuario->persona_id = $persona->id;
    	$this->assertTrue($usuario->save());
    	$propi = new \App\Propietario();
    	$propi->persona_id = $persona->id;
    	$this->assertTrue($propi->save());
    	$casa = \App\Casa::find(8);
    	$casa->propietario_id = $propi->id;
    	$this->assertTrue($casa->save());

    }
    public function testRegistrarPropietarioMultiple(){
    	#dueña de la casa 1 y 2
    	$persona = new \App\Persona();
    	$persona->cedula = '9876543217';
    	$persona->nombres = 'Valeria Michell';
    	$persona->apellidos = 'Polo Melendez';
    	$persona->sexo = 'Femenino';
    	$persona->fecha_nacimiento = '1985/02/21';
    	$persona->telefono = '3106543149';
    	$persona->email = 'vmpolo@unicesar.edu.co';
    	$this->assertTrue($persona->save());
    	$usuario = new \App\User();
    	$usuario->name = 'vmpolo';
    	$usuario->password = Hash::make('secret');
    	$usuario->rol = 'Propietario';
    	$usuario->persona_id = $persona->id;
    	$this->assertTrue($usuario->save());
    	$propi = new \App\Propietario();
    	$propi->persona_id = $persona->id;
    	$this->assertTrue($propi->save());
    	$casa = \App\Casa::find(1);
    	$casa->propietario_id = $propi->id;
    	$this->assertTrue($casa->save());
    	$casa = \App\Casa::find(2);
    	$casa->propietario_id = $propi->id;
    	$this->assertTrue($casa->save());
    }
}
