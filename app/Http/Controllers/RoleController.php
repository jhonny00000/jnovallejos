<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveRoleRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $roles = Role::query()
            ->withCount('users')
            ->when($search, fn ($query, string $search) => $query->where('nombre', 'like', "%{$search}%"))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('roles.index', compact('roles', 'search'));
    }

    public function create(): View
    {
        return view('roles.form');
    }

    public function store(SaveRoleRequest $request): RedirectResponse
    {
        Role::create($request->validated());

        return to_route('roles.index')->with('status', 'Rol creado correctamente.');
    }

    public function show(Role $role): RedirectResponse
    {
        return to_route('roles.edit', $role);
    }

    public function edit(Role $role): View
    {
        return view('roles.form', compact('role'));
    }

    public function update(SaveRoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        return to_route('roles.index')->with('status', 'Rol actualizado correctamente.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $this->authorize('admin');

        if ($role->users()->exists()) {
            return back()->with('error', 'Este rol tiene usuarios asignados.');
        }

        $role->delete();

        return to_route('roles.index')->with('status', 'Rol eliminado correctamente.');
    }
}
