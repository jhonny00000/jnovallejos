@extends('layouts.app')

@section('title', 'Seguridad')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-6">Seguridad</h1>

                <h2 class="text-lg font-semibold mb-4">Cambiar contraseña</h2>

                <form method="POST" action="{{ route('user-password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="current_password" class="block font-medium text-sm text-gray-700">Contraseña actual</label>
                        <input id="current_password" type="password" name="current_password" required
                               class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('current_password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block font-medium text-sm text-gray-700">Nueva contraseña</label>
                        <input id="password" type="password" name="password" required
                               class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirmar contraseña</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Actualizar contraseña
                        </button>
                    </div>
                </form>

                @if ($canManageTwoFactor ?? false)
                    <hr class="my-8">
                    <h2 class="text-lg font-semibold mb-4">Autenticación de dos factores</h2>
                    <p class="text-gray-600">La gestión de 2FA está disponible en la interfaz de seguridad.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
