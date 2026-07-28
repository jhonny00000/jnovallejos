<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $users = User::query()
            ->with('role:id,nombre')
            ->when($search, fn ($query, string $search) => $query->where('name', 'like', "%{$search}%"))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'search'));
    }

    public function create(): View
    {
        $roles = Role::orderBy('nombre')->get(['id', 'nombre']);

        return view('users.form', compact('roles'));
    }

    public function store(SaveUserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return to_route('users.index')->with('status', 'Usuario creado correctamente.');
    }

    public function show(User $user): RedirectResponse
    {
        return to_route('users.edit', $user);
    }

    public function edit(User $user): View
    {
        $roles = Role::orderBy('nombre')->get(['id', 'nombre']);

        return view('users.form', compact('user', 'roles'));
    }

    public function update(SaveUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (blank($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return to_route('users.index')->with('status', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('admin');

        $user->delete();

        return to_route('users.index')->with('status', 'Usuario eliminado correctamente.');
    }
}
