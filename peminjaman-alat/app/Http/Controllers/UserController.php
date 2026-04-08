<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'nama'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,petugas,peminjam',
        ]);

        User::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'nama'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,petugas,peminjam',
        ]);

        $data = $request->only(['username', 'nama', 'email', 'role']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
