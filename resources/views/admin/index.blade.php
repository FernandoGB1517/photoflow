@extends('layouts.app')

@section('titulo', 'Lista de Usuarios')

@section('contenido')
    <div class="container mx-auto mt-10">
        <div class="bg-white shadow-md rounded-lg p-5">
            <form id="filterForm" action="{{ route('admin.users.filtrar') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" id="nombre" name="nombre" value="{{ request()->get('nombre') }}" placeholder="Filtrar por nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Nombre de Usuario</label>
                        <input type="text" id="username" name="username" value="{{ request()->get('username') }}" placeholder="Filtrar por nombre de usuario" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="text" id="email" name="email" value="{{ request()->get('email') }}" placeholder="Filtrar por email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    </div>

                    <div class="text-center mb-10">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Aplicar Filtros
                        </button>
                        <a href="{{ route('admin.index',auth()->user()->username ) }}" class=" btn btn-outline-secondary ml-2  hover:text-gray-700 text-gray-500 font-bold py-1 px-4 rounded">
                            Limpiar Filtros
                        </a>
                    </div>
                </div>
               
            </form>


            <table class="min-w-full divide-y divide-gray-200 mt-10">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->username }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- Iconos para las acciones -->
                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-gray-500 hover:text-blue-500 mx-1" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-gray-500 hover:text-green-500 mx-1" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-500 hover:text-red-500 mx-1" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center">
                            <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Crear Usuario
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Agregar enlaces de paginación -->
            <div class="mt-4">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
