<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class propietarioController extends Controller
{
	public function __construct()
	  {
	    $this->middleware('auth');
	  }

	public function index(){
		return view('Propietario.index');
	}
	public function misCasasForm(){
		$listaCasas = auth()->user()->persona->propietario->misCasas;
		return view('Propietario.misCasas',compact('listaCasas'));
	}
}
