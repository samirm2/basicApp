<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use \App\User;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function login(){
        // request()->validate([
        //     'username' => 'exists:users,name'
        // ]);

        if(Auth::attempt(['name'=>request()->username,'password'=>request()->password])){
            $usuario = User::where("name",request()->username)->first();
            // session(['user'=>$usuario->name]);
            return ['ban'=> 1,'mensaje'=>$usuario->persona->NombreCompleto,'url'=>url('/'.$usuario->rol)];
        }else{
            return ['ban'=>0, 'mensaje'=>trans('auth.failed')];
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/')->with('mensajeLogout','Su sesion ha finalizado correctamente');
    }
}
