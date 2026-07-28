@extends('layouts.app')

@section('title', isset($user) ? 'Editar Usuario' : 'Nuevo Usuario')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-6">{{ isset($user) ? 'Editar Usuario' : 'Nuevo Usuario' }}</h1>

                <form method="POST" action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}">
                    @csrf
                    @if (isset($user))
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="role_id" class="block font-medium text-sm text-gray-700">Rol</label>
                        <select id="role_id" name="role_id" required
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Seleccionar rol</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                    {{ $role->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700">Nombre</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
                               class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="a_paterno" class="block font-medium text-sm text-gray-700">Apellido Paterno</label>
                        <input id="a_paterno" type="text" name="a_paterno" value="{{ old('a_paterno', $user->a_paterno ?? '') }}" required
                               class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('a_paterno')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="a_materno" class="block font-medium text-sm text-gray-700">Apellido Materno</label>
                        <input id="a_materno" type="text" name="a_materno" value="{{ old('a_materno', $user->a_materno ?? '') }}"
                               class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('a_materno')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="ci" class="block font-medium text-sm text-gray-700">CI</label>
                        <input id="ci" type="text" name="ci" value="{{ old('ci', $user->ci ?? '') }}" required
                               class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('ci')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                               class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block font-medium text-sm text-gray-700">
                            Contraseña {{ isset($user) ? '(dejar vacío para mantener la actual)' : '' }}
                        </label>
                        <input id="password" type="password" name="password" {{ isset($user) ? '' : 'required' }}
                               class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ isset($user) ? 'Actualizar' : 'Guardar' }}
                        </button>
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
