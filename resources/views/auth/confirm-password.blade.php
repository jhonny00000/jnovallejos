@extends('layouts.guest')

@section('title', 'Confirmar contraseña')

@section('content')
<div>
    <div class="mb-4 text-sm text-gray-600">
        Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            <label for="password" class="block font-medium text-sm text-gray-700">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Confirmar
            </button>
        </div>
    </form>
</div>
@endsection
