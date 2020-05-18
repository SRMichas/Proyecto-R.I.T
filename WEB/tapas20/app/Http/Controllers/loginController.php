<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class loginController extends Controller
{
    //
    public function vistaLogin()
    {
        return view('login.index');
    }
    public function acceder(Request $request)
    { 
        $username = $request->username;
            
         $users = App\Usuario::where('email',$request->username);
         if(count($users->get())>0)
         {
          $request->session()->put('usuario',$request->username);
          return redirect()->action('usuariosController@vistaPrincipal');
         }
         else{
             return back()->with('nota','contraseña o usuario incorrecto');
         }
        
    }
    public function cerrar()
    {
        session()->flush();
        return redirect()->action('homeController@inicio');  
    }
}
