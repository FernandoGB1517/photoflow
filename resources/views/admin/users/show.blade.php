@extends('layouts.app')

@section('titulo')
    <span class="text-gray-500">Editar Perfil: </span> <em>{{ $user->username }}</em>
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
         
                @csrf

                <div class="mb-5">
                    <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre
                    </label>

                    <input 
                        type="text"
                        id="name"
                        name='name'
                        placeholder="Tu Nombre"
                        class="border p-3 w-full rounded-lg 
                        @error('name')
                            border-red-500
                        @enderror"
                        value="{{ $user->name }}"
                        readonly
                    />
                </div>

                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre de Usuario
                    </label>

                    <input 
                        type="text"
                        id="username"
                        name='username'
                        placeholder="Tu Nombre de Usuario"
                        class="border p-3 w-full rounded-lg 
                        @error('username')
                            border-red-500
                        @enderror"
                        value="{{ $user->username }}"
                        readonly
                    />
                </div>

                <div class="mb-5">
                    <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>

                    <input 
                        type="text"
                        id="email"
                        name='email'
                        placeholder="email"
                        class="border p-3 w-full rounded-lg 
                        @error('email')
                            border-red-500
                        @enderror"
                        value="{{ $user->email }}"
                        readonly
                    />
                </div>

                <!-- Selectores de Comunidad Autónoma, Provincia y Localidad -->
                <div class="mb-5">
                    <label for="comunidad_autonoma" class="mb-2 block uppercase text-gray-500 font-bold">
                        Comunidad Autónoma
                    </label>

                    <input 
                        type="text"
                        id="comunidad"
                        name='comunidad'
                        placeholder="Tu Comunidad"
                        class="border p-3 w-full rounded-lg 
                        @error('name')
                            border-red-500
                        @enderror"
                        value="{{ optional($comunidadUsuario)->Nombre ?: 'Sin asignar' }}"
                        readonly
                    />
                   
                </div>

                <div class="mb-5">
                    <label for="provincia" class="mb-2 block uppercase text-gray-500 font-bold">
                        Provincia
                    </label>
                    <input 
                        type="text"
                        id="provincia"
                        name='provincia'
                        placeholder="Tu Provincia"
                        class="border p-3 w-full rounded-lg 
                        @error('name')
                            border-red-500
                        @enderror"
                        value="{{ optional($provinciaUsuario)->Provincia ?: 'Sin asignar' }}"
                        readonly
                    />
                </div>

                <div class="mb-5">
                    <label for="localidad" class="mb-2 block uppercase text-gray-500 font-bold">
                        Localidad
                    </label>
                    <input 
                        type="text"
                        id="localidad"
                        name='localidad'
                        placeholder="Tu Localidad"
                        class="border p-3 w-full rounded-lg 
                        @error('name')
                            border-red-500
                        @enderror"
                        value="{{ optional($localidadUsuario)->Municipio ?: 'Sin asignar' }}"
                        readonly
                    />
                </div>

                <div class="text-center">
                    <a href="{{ route('admin.index', ['user' => auth()->user()->username]) }}"  class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full rounded-lg p-3 text-white">Volver</a>
                </div>

        </div>
</div>
@endsection