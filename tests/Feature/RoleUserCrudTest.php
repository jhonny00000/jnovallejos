<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

test('roles can be listed and created', function () {
    $admin = User::factory()->create();

    $this
        ->actingAs($admin)
        ->post(route('roles.store'), [
            'nombre' => 'Administrador',
            'descripcion' => 'Gestiona todo el sistema.',
        ])
        ->assertRedirect(route('roles.index'));

    $this->assertDatabaseHas('roles', [
        'nombre' => 'Administrador',
        'descripcion' => 'Gestiona todo el sistema.',
    ]);

    $this
        ->actingAs($admin)
        ->get(route('roles.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('roles/Index')
            ->has('roles.data', 2)
            ->where('roles.data.0.nombre', 'Administrador'),
        );
});

test('users can be listed with their role and searched by name', function () {
    $admin = User::factory()->create(['name' => 'Admin User']);
    $sellerRole = Role::factory()->create(['nombre' => 'Vendedor']);
    User::factory()->create([
        'role_id' => $sellerRole->id,
        'name' => 'Maria',
        'a_paterno' => 'Lopez',
        'email' => 'maria@example.com',
        'ci' => '456789',
    ]);
    User::factory()->create(['name' => 'Carlos']);

    $this
        ->actingAs($admin)
        ->get(route('users.index', ['search' => 'Maria']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('users/Index')
            ->where('filters.search', 'Maria')
            ->has('users.data', 1)
            ->where('users.data.0.name', 'Maria')
            ->where('users.data.0.role.nombre', 'Vendedor'),
        );
});

test('users can be created and updated with a role', function () {
    $admin = User::factory()->create();
    $sellerRole = Role::factory()->create(['nombre' => 'Vendedor']);
    $managerRole = Role::factory()->create(['nombre' => 'Administrador']);

    $this
        ->actingAs($admin)
        ->post(route('users.store'), [
            'role_id' => $sellerRole->id,
            'name' => 'Luis',
            'a_paterno' => 'Perez',
            'a_materno' => 'Rojas',
            'ci' => '987654',
            'email' => 'luis@example.com',
            'password' => 'password',
        ])
        ->assertRedirect(route('users.index'));

    $user = User::where('email', 'luis@example.com')->firstOrFail();

    expect($user->role_id)->toBe($sellerRole->id);

    $this
        ->actingAs($admin)
        ->put(route('users.update', $user), [
            'role_id' => $managerRole->id,
            'name' => 'Luis Alberto',
            'a_paterno' => 'Perez',
            'a_materno' => 'Rojas',
            'ci' => '987654',
            'email' => 'luis@example.com',
            'password' => null,
        ])
        ->assertRedirect(route('users.index'));

    expect($user->refresh())
        ->name->toBe('Luis Alberto')
        ->role_id->toBe($managerRole->id);
});
