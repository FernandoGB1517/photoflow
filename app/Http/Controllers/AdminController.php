<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comunidad;
use App\Models\Localidad;
use App\Models\Provincia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function index()
    {

        $users = User::paginate(4);

        return view('admin.index', compact('users')); 
    }

    public function show(User $user)
    {
        $comunidades = Comunidad::all();
        $provincias = Provincia::all();
        $localidades = Localidad::all();
    
        // Obtener los nombres de la comunidad, provincia y localidad del usuario
        $comunidadUsuario = Comunidad::where('idCCAA', $user->idCCAA)->first();
        $provinciaUsuario = Provincia::where('idProvincia', $user->idProvincia)->first();
        $localidadUsuario = Localidad::where('idMunicipio', $user->idMunicipio)->first();

        return view('admin.users.show', compact('user', 'comunidadUsuario', 'provinciaUsuario', 'localidadUsuario'));
    }

    public function edit(User $user)
    {
        $usuario = auth()->user();
        $comunidades = Comunidad::all();
        $provincias = Provincia::all();
        $localidades = Localidad::all();
    
        // Obtener los nombres de la comunidad, provincia y localidad del usuario
        $comunidadUsuario = Comunidad::where('idCCAA', $user->idCCAA)->first();
        $provinciaUsuario = Provincia::where('idProvincia', $user->idProvincia)->first();
        $localidadUsuario = Localidad::where('idMunicipio', $user->idMunicipio)->first();
    
        return view('admin.users.edit', compact('user', 'comunidades', 'provinciaUsuario', 'localidadUsuario'));
    }
    
    public function update(Request $request, User $user)
    {

        $this->validate($request, [
            'name' => ['required',
            'unique:users,username,'.$user->id, 
            'min:3', 
            'max:20', 
            'not_in:twitter,editar-perfil'],
        ]);


        $this->validate($request, [
            'username' => ['required',
            'unique:users,username,'.$user->id, 
            'min:3', 
            'max:20', 
            'not_in:twitter,editar-perfil'],
        ]);

        $this->validate($request, [
            'email' => ['required',
            'unique:users,username,'.$user->id, 
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


        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->imagen = $nombreImagen ?? $user->imagen ?? null;

        // Asignar comunidad, provincia y municipio
        $user->idCCAA = $request->comunidad_autonoma;
        $user->idProvincia = $request->provincia;
        $user->idMunicipio = $request->localidad;
        
        $user->update();
    
        return redirect()->route('admin.index', ['user' => auth()->user()->username])
                         ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {

        // Verificar si el usuario a eliminar es el usuario admin
        if ($user->rol=== 'admin') {
            return redirect()->route('admin.index', ['user' => auth()->user()->username])->with('error', 'No puedes eliminar al usuario admin.');
        }

        $user->delete();

        return redirect()->route('admin.index', ['user' => auth()->user()->username])
                         ->with('success', 'Usuario eliminado correctamente');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
         // Validación de los datos de entrada
    $validatedData = $request->validate([
        'name' => ['required', 'max:30'],
        'username' => ['required', 'unique:users', 'min:3', 'max:20'],
        'email' => ['required', 'unique:users', 'email', 'max:60'],
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

    // Crear el usuario en la base de datos
    $user = User::create([
        'name' => $validatedData['name'],
        'username' => $validatedData['username'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'rol' => 'user',
    ]);
        return redirect()->route('admin.index', ['user' => auth()->user()->username])
                         ->with('success', 'User created successfully');
    }

    public function filtrar(Request $request)
{
    $query = User::query();

    // Aplicar filtros si existen en la solicitud
    if ($request->filled('nombre')) {
        $query->where('name', 'like', '%' . $request->input('nombre') . '%');
    }
    
    if ($request->filled('username')) {
        $query->where('username', 'like', '%' . $request->input('username') . '%');
    }
    
    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->input('email') . '%');
    }

    // Obtener los usuarios filtrados
    $users = $query->paginate(4); // Puedes ajustar el número de usuarios por página según tus necesidades

    return view('admin.index', compact('users'));
}
}
