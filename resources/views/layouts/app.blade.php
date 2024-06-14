<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @stack('styles')

        <link rel="icon" href="{{asset('img/Logo.png')}}" type="image/x-icon">

        <title>PhotoFlow {{--- @yield('titulo') --}}</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        @vite('resources/css/app.css')
        @vite('resources/js/app.js')

        @livewireStyles

        <style>
            .custom-hover:hover {
                background-color: #E9D5FF; /* Bootstrap's equivalent to a pink shade */
                transition: background-color 0.3s ease; /* Smooth transition effect */
            }

            @keyframes rotacion {
            0% {
                transform: translate(50%, 50%) rotate(0deg);
                opacity: 0;
                position: relative;
            }

            100% {
                transform: translate(0, 0) rotate(360deg);
                opacity: 1;
            }
        }

        .animate-link {
            animation: rotacion 1s ease-in-out forwards;
            position: relative;
        }
        </style>
    </head>
    <body class="bg-gray-100">
        <header class="p-5 border-b bg-purple-100 shadow flex "
                style="background: rgb(194,100,45);
                background: linear-gradient(240deg, rgba(194,100,45,1) 0%, rgba(155,95,172,1) 35%, rgba(0,160,174,1) 100%);">
            <div class="container mx-auto flex justify-between items-center gap-4">
                <a href="{{ route('home') }}" 
                class="text-3xl font-black text-gray-600 flex items-center bg-gray-100 px-2 rounded-xl custom-hover animate-link"
                style="position: relative;">
                    <img src="{{asset('img/Logo.png')}}" alt="Logo" style="width: 3rem; height: auto;">
                    <span style="text-shadow: 2px 2px 0px  rgba(233,213,255,1); font-family: 'Brush Script MT', cursive; font-size: 2.5rem; padding-right: 0.5rem">PhotoFlow</span>
                </a>

                @auth
                <nav class="flex gap-4 items-center md:flex-row flex-col">                           

                    <livewire:buscar-usuarios />

                    <a
                        class="flex items-center gap-2 bg-white border p-2 text-gray-600 rounded text-sm uppercase font-bold cursor-pointer"
                        href="{{route('posts.create')}}"
                    >

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                    </svg>
                        Crear
                    </a>

                    <a class="font-bold text-gray-600 text-sm"  href="{{ route('posts.index', auth()->user()->username ) }}">
                        Hola: 
                        <span class="font-normal">
                            {{ auth()->user()->username }}
                        </span>
                    </a>

                    @if(auth()->user()->rol === 'admin')
                        <a class="font-bold text-gray-600 uppercase text-sm" href="{{ route('admin.index',auth()->user()->username ) }}
                        ">
                            Panel Admin
                        </a>
                    @endif
                    

                    <form action="{{  route('logout')}}" method="POST">
                        @csrf
                        <button type="submit" class="font-bold uppercase text-gray-600 text-sm">
                            Cerrar Sesión
                        </button>
                    </form>
                </nav>
                @endauth

                @guest()
                    <nav class="flex gap-4 items-center md:flex-row flex-col">

                        <livewire:buscar-usuarios />

                        <a class="font-bold uppercase text-gray-600 text-sm"  href="{{ route('login') }}">Login</a>

                        <a class="font-bold uppercase text-gray-600 text-sm"  href="{{ route('register') }}">Crear Cuenta</a>
                    </nav>
                @endguest

            </div>
        </header>

        <main class="container mx-auto mt-10">
            <h2 class="font-black text-center text-3xl mb-10">
                @yield('titulo')
            </h2>
            @yield('contenido')
        </main>

        <footer class="text-center p-10 text-gray-500 font-bold ">
            <p>
                <span style="text-shadow: 2px 2px 0px  rgba(233,213,255,1); font-family: 'Brush Script MT', cursive; font-size: 1.5rem;"
                class=" text-gray-600 ">PhotoFlow </span>
                - TODOS LOS DERECHOS RESERVADOS  
            {{ now()->year }}
            </p>
        </footer>

        @livewireScripts
        
        @stack('scripts')
    </body>
</html>