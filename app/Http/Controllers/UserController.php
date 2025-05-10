<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        $users = User::all();
        // tidak mengembalikan user dengan role admin
        $users = $users->filter(function ($user) {
            return $user->role !== 'Admin';
        });
        return view('user.index', compact('users'));
    }

    // Menampilkan form tambah user
    public function create()
    {
        return view('user.create');
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $this->validateRequest($request);

        User::create($this->fillUserData($request));

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    // Menampilkan form edit user
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    // Menyimpan perubahan user
    public function update(Request $request, User $user)
    {
        $this->validateRequest($request, $user->id);

        $user->update($this->fillUserData($request, $user->password));

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    // Menghapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }

    // Validasi inputan
    private function validateRequest(Request $request, $userId = null)
    {
        $uniqueEmailRule = 'unique:users,email' . ($userId ? ',' . $userId : '');

        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', $uniqueEmailRule],
            'role' => 'required|in:Admin,Pharmacist,Technician',
            'password' => $userId ? 'nullable|min:6' : 'required|min:6',
            'status' => 'required|in:active,inactive',
        ]);
    }

    // Menyusun data user
    private function fillUserData(Request $request, $existingPassword = null)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password
                ? Hash::make($request->password)
                : $existingPassword,
            'status' => $request->status,
        ];
    }
}
