@extends('layouts.app')

@section('titulo')
    <span class="text-gray-500">Editar Perfil: </span> <em>{{ $user->username}}</em>
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form method="POST" action="{{ route('admin.users.update',  $user) }}" enctype="multipart/form-data" class="mt-10 md:mt-0">
                @csrf
                @method('PUT')
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
                        value="{{$user->name}}"
                    />

                    @error('name')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
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
                        value="{{$user->username}}"
                    />

                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
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
                        value="{{$user->email}}"
                    />

                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                 <!-- Selectores de Comunidad Autónoma, Provincia y Localidad -->
                 <div class="mb-5">
                    <label for="comunidad_autonoma" class="mb-2 block uppercase text-gray-500 font-bold">
                        Comunidad Autónoma
                    </label>
                    <select id="comunidad_autonoma" name="comunidad_autonoma" class="border p-3 w-full rounded-lg bg-gray-100">
                        <option value="">Selecciona una Comunidad Autónoma</option>
                        @foreach($comunidades as $comunidad)
                            <option value="{{ $comunidad->idCCAA }}" 
                                {{ $comunidad->idCCAA == $user->idCCAA ? 'selected' : '' }}>
                                {{ $comunidad->Nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label for="provincia" class="mb-2 block uppercase text-gray-500 font-bold">
                        Provincia
                    </label>
                    <select id="provincia" name="provincia" class="border p-3 w-full rounded-lg bg-gray-100">
                        @if($user->idProvincia)
                            <option value="{{ $user->idProvincia}}" selected>{{ $provinciaUsuario->Provincia }}</option>
                        @else
                            <option value="">Selecciona una Provincia</option>
                        @endif
                        <!-- Aquí se cargarán las provincias dinámicamente con JavaScript -->
                    </select>
                </div>

                <div class="mb-5">
                    <label for="localidad" class="mb-2 block uppercase text-gray-500 font-bold">
                        Localidad
                    </label>
                    <select id="localidad" name="localidad" class="border p-3 w-full rounded-lg bg-gray-100">
                        @if($user->idMunicipio)
                            <option value="{{ $user->idMunicipio}}" selected>{{ $localidadUsuario->Municipio }}</option>
                        @else
                            <option value="">Selecciona una Localidad</option>
                        @endif
                        <!-- Aquí se cargarán las localidades dinámicamente con JavaScript -->
                    </select>
                </div>
                
                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nuevo Password
                    </label>

                    <div class="relative">
                        <input 
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Nuevo Password"
                            class="border p-3 w-full rounded-lg
                            @error('password')
                                border-red-500
                            @enderror"
                        />

                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 cursor-pointer"
                                onclick="togglePasswordVisibility()">
                            <i id="togglePassword" class="far fa-eye"></i>
                        </span>
                    </div>

                    @error('password')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password_confirmation" class="mb-2 block uppercase text-gray-500 font-bold">
                        Repetir Password
                    </label>

                    <div class="relative">
                        <input 
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Repetir Nuevo Password"
                            class="border p-3 w-full rounded-lg"
                        />
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 cursor-pointer"
                                onclick="togglePasswordVisibilityRepeat()">
                            <i id="togglePasswordRepeat" class="far fa-eye"></i>
                        </span>
                    </div>


                <div class="mb-5">
                    <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">
                        Imagen Perfil
                    </label>

                    <input 
                        type="file"
                        id="imagen"
                        name="imagen"
                        class="border p-3 w-full rounded-lg 
                        value=""
                        accept=".jpg, .jpej, .png"
                    />
                </div>

                <input 
                    type="submit"
                    value="Guardar Cambios"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full rounded-lg p-3 text-white"
                />

                <div class="text-center mt-5">
                    <a href="{{  route('admin.index', ['user' => auth()->user()->username]) }}"  class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full rounded-lg p-3 text-white">Cancelar</a>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const comunidadSelect = document.getElementById('comunidad_autonoma');
                const provinciaSelect = document.getElementById('provincia');
                const localidadSelect = document.getElementById('localidad');
        
                comunidadSelect.addEventListener('click', function() {
                    const comunidadId = this.value;
                    provinciaSelect.innerHTML = '<option value="">Selecciona una Provincia</option>';
                    localidadSelect.innerHTML = '<option value="">Selecciona una Localidad</option>';
                    
                    fetch(`/provincias/${comunidadId}`)
                        .then(response => response.json())
                        .then(provincias => {
                            
                            provincias.forEach(provincia => {
                                const option = document.createElement('option');
                                option.value = provincia.idProvincia;
                                option.textContent = provincia.Provincia;
                                provinciaSelect.appendChild(option);
                            });
                        });
                });
        
                provinciaSelect.addEventListener('click', function() {
                    const provinciaId = this.value;
                    fetch(`/localidades/${provinciaId}`)
                        .then(response => response.json())
                        .then(localidades => {
                            localidadSelect.innerHTML = '<option value="">Selecciona una Localidad</option>';
                            localidades.forEach(localidad => {
                                const option = document.createElement('option');
                                option.value = localidad.idMunicipio;
                                option.textContent = localidad.Municipio;
                                localidadSelect.appendChild(option);
                            });
                        });
                });
            });
        </script>

        <script>
            function togglePasswordVisibility() {
                var passwordInput = document.getElementById('password');
                var toggleIcon = document.getElementById('togglePassword');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            }

            function togglePasswordVisibilityRepeat() {
                var passwordInputR = document.getElementById('password_confirmation');
                var toggleIconR = document.getElementById('togglePasswordRepeat');

                if (passwordInputR.type === 'password') {
                    passwordInputR.type = 'text';
                    toggleIconR.classList.remove('fa-eye');
                    toggleIconR.classList.add('fa-eye-slash');
                } else {
                    passwordInputR.type = 'password';
                    toggleIconR.classList.remove('fa-eye-slash');
                    toggleIconR.classList.add('fa-eye');
                }
            }
            
        </script>
        
    </div>
@endsection