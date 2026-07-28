@extends('layouts.guest')

@section('title', 'Autenticación de dos factores')

@section('content')
<div>
    <div class="mb-4 text-sm text-gray-600">
        Ingresa el código de autenticación de dos factores para continuar.
    </div>

    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <div>
            <label for="code" class="block font-medium text-sm text-gray-700">Código</label>
            <input id="code" type="text" name="code" inputmode="numeric" autofocus autocomplete="one-time-code"
                   class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('code')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Verificar
            </button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">O usa uno de tus códigos de recuperación.</p>
    </div>

    <form method="POST" action="{{ route('two-factor.login') }}" class="mt-4">
        @csrf

        <div>
            <label for="recovery_code" class="block font-medium text-sm text-gray-700">Código de recuperación</label>
            <input id="recovery_code" type="text" name="recovery_code" autocomplete="one-time-code"
                   class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('recovery_code')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Usar código de recuperación
            </button>
        </div>
    </form>
</div>
@endsection
