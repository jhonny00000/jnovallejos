@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
                <p>Bienvenido, {{ Auth::user()->name }}.</p>
                <p class="mt-2">Rol: <strong>{{ Auth::user()->role?->nombre ?? 'Sin rol' }}</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
