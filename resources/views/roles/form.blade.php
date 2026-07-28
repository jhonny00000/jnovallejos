@extends('layouts.app')

@section('title', isset($role) ? 'Editar Rol' : 'Nuevo Rol')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-6">{{ isset($role) ? 'Editar Rol' : 'Nuevo Rol' }}</h1>

                <form method="POST" action="{{ isset($role) ? route('roles.update', $role) : route('roles.store') }}">
                    @csrf
                    @if (isset($role))
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="nombre" class="block font-medium text-sm text-gray-700">Nombre</label>
                        <input id="nombre" type="text" name="nombre" value="{{ old('nombre', $role->nombre ?? '') }}" required
                               class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('nombre')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="block font-medium text-sm text-gray-700">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3"
                                  class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $role->descripcion ?? '') }}</textarea>
                        @error('descripcion')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ isset($role) ? 'Actualizar' : 'Guardar' }}
                        </button>
                        <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
