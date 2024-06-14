<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Comunidad;
use App\Models\Provincia;
use App\Models\Localidad;

class PerfilController extends Controller
{
    public function __construct(){
        $this->middleware(('auth'));
    }

    public function index() {
        $usuario = auth()->user();
        $comunidades = Comunidad::all();
        $provincias = Provincia::all();
        $localidades = Localidad::all();
    
        // Obtener los nombres de la comunidad, provincia y localidad del usuario
        $comunidadUsuario = Comunidad::where('idCCAA', $usuario->idCCAA)->first();
        $provinciaUsuario = Provincia::where('idProvincia', $usuario->idProvincia)->first();
        $localidadUsuario = Localidad::where('idMunicipio', $usuario->idMunicipio)->first();
    
        return view('perfil.index', [
            'comunidades' => $comunidades,
            'provincias' => $provincias,
            'localidades' => $localidades,
            'usuario' => $usuario,
            'comunidadUsuario' => $comunidadUsuario,
            'provinciaUsuario' => $provinciaUsuario,
            'localidadUsuario' => $localidadUsuario
        ]);
    }
    
    public function store(Request $request) 
    {
        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'name' => ['required',
            'unique:users,username,'.auth()->user()->id, 
            'min:3', 
            'max:20', 
            'not_in:twitter,editar-perfil'],
        ]);


        $this->validate($request, [
            'username' => ['required',
            'unique:users,username,'.auth()->user()->id, 
            'min:3', 
            'max:20', 
            'not_in:twitter,editar-perfil'],
        ]);

        $this->validate($request, [
            'email' => ['required',
            'unique:users,username,'.auth()->user()->id, 
            'email',
            'max:60'],
        ]);

        if ($request->filled('password')) {
            $this->validate($request,[
                'password' => ['required',
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
        }

        if($request->imagen){
            //dd('si hay imagen');

            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imagenServidor = Image::make($imagen);

            $imagenServidor->fit(1000, 1000);

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        //Guardar cambios
        $usuario = User::find(auth()->user()->id);

        $usuario->name = $request->name;
        $usuario->username = $request->username;
        $usuario->email = $request->email;

        if ($request->filled('password')) {
            $usuario->password = $request->password;
        }

        
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;

        // Asignar comunidad, provincia y municipio
        $usuario->idCCAA = $request->comunidad_autonoma;
        $usuario->idProvincia = $request->provincia;
        $usuario->idMunicipio = $request->localidad;
        
        $usuario->save();

        //Redireccionar
        return redirect()->route('posts.index', $usuario->username);
        
    }
}
