@extends('layouts.app')

@section('titulo')
    Inicia Sesión en PhotoFlow
@endsection

@section('contenido')
    <div class="md:flex md:justify-center md:gap-10 md:items-center px-4">
        <div class="md:w-6/12 p-5">
            <img src="{{asset('img/Login.jpg')}}" alt="Imagen login de usuarios">
        </div>

        <div class="md:w-4/12 bg-white shadow p-5 rounded-lg">
            <form action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                @if(session('mensaje'))

                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                    {{ session('mensaje') }}
                </p>
                @endif

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>

                    <input 
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Tu Email "
                        class="border p-3 w-full rounded-lg 
                        @error('email')
                            border-red-500
                        @enderror"
                        value="{{ old('email') }}"
                    />

                    @error('email')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}
                    </p>
                @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password
                    </label>

                    <div class="relative">
                        <input 
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Password "
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
                    <input type="checkbox" name="remember"> 
                    <label class=" text-gray-500 text-sm">
                        Mantener mi sesión abierta
                    </label> 
                </div>

                <input 
                    type="submit"
                    value="Iniciar Sesión"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full rounded-lg p-3 text-white"
                />
            </form>
        </div>
        
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
        </script>
    </div>
@endsection