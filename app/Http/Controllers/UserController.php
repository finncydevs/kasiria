<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,kasir,owner',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = $request->has('status') ? true : false;

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,kasir,owner',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'boolean',
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Toggle user status (active/inactive).
     */
    public function toggleStatus(User $user)
    {
        $user->update(['status' => !$user->status]);
        return back()->with('success', 'Status pengguna berhasil diubah.');
    }

    /**
     * Reset user password to default.
     */
    public function resetPassword(User $user)
    {
        $defaultPassword = 'Password123!';
        $user->update(['password' => Hash::make($defaultPassword)]);

        return back()->with('success', "Password pengguna berhasil direset. Password baru: {$defaultPassword}");
    }
}
