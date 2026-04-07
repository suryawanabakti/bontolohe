<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'kader_posyandu']), 403, 'Anda tidak memiliki akses ke halaman ini.');
        
        $users = User::with('roles')->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'kader_posyandu']), 403, 'Anda tidak memiliki akses ke halaman ini.');

        $roles = Role::whereIn('name', ['kader_posyandu', 'ibu_hamil', 'orang_tua'])->get();
        if (auth()->user()->hasRole('admin')) {
            $roles = Role::all();
        }
        
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'kader_posyandu']), 403, 'Anda tidak memiliki akses ke halaman ini.');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'kader_posyandu']), 403, 'Anda tidak memiliki akses ke halaman ini.');

        $roles = Role::whereIn('name', ['kader_posyandu', 'ibu_hamil', 'orang_tua'])->get();
        if (auth()->user()->hasRole('admin')) {
            $roles = Role::all();
        }

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'kader_posyandu']), 403, 'Anda tidak memiliki akses ke halaman ini.');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        $user->syncRoles([$validated['role']]);

        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'kader_posyandu']), 403, 'Anda tidak memiliki akses ke halaman ini.');

        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}


