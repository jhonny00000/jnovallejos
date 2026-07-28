@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Roles</h1>
                    <a href="{{ route('roles.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Nuevo Rol
                    </a>
                </div>

                <form method="GET" action="{{ route('roles.index') }}" class="mb-6">
                    <div class="flex gap-2">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por nombre..."
                               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                            Buscar
                        </button>
                        @if ($search)
                            <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Limpiar
                            </a>
                        @endif
                    </div>
                    @if ($search)
                        <p class="mt-2 text-sm text-gray-600">
                            Mostrando resultados para: <strong>{{ $search }}</strong>
                        </p>
                    @endif
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuarios</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($roles as $role)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $role->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $role->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $role->descripcion }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $role->users_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                        <a href="{{ route('roles.edit', $role) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        @can('admin')
                                            <form method="POST" action="{{ route('roles.destroy', $role) }}" class="inline" onsubmit="return confirm('¿Eliminar este rol?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No se encontraron roles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
