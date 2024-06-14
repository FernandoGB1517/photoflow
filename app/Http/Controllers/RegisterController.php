<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request) 
    {
        // dd($request); 
        // dd($request->get('username'));

        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);

        // Validación
        $this->validate($request,[
            'name'=> 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => [
                'required',
                'confirmed',
                'min:6',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/', 
                'regex:/[!@#$%^&*()\-_=+{};:,<.>]/',
                ],
            ], [
            'password.regex' => 'El campo :attribute debe contener al menos una letra minúscula, una mayúscula, un número y un símbolo.',
            ]);
        
        
        // dd('Creando usuario...');

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'rol' => 'user'

             /*
            'password' => Hash::make($required->password)
            Ya no es necesario en Laravel 10
            */
        ]);

        // Autenticar un usuario
        /*
        auth()->attempt([
            'email'=> $request->email,
            'password'=> $request->password
        ]);
        */

        // Otra forma de autenticar
        auth()->attempt($request->only('email','password'));

        //Redireccionar al Usuario
        //return redirect()->route('posts.index');

        $user = auth()->user(); // Obtén el usuario autenticado.

        // Asegúrate de que el usuario tenga un atributo 'id' o ajusta esto según tu modelo de usuario.
        return redirect()->route('posts.index', ['user' => $user->username]);
    }
}
