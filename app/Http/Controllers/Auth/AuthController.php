<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Try to authenticate with username or email
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $request->filled('remember')) ||
            Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']], $request->filled('remember'))) {

            $user = Auth::user();

            // Check if user is active
            if (!$user->status) {
                Auth::logout();
                return back()->withErrors(['username' => 'Akun Anda telah dinonaktifkan.']);
            }

            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Selamat datang, ' . $user->nama);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    /**
     * Show the register form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'kasir', // Default role
            'no_hp' => $validated['no_hp'] ?? null,
            'status' => false, // Requires admin approval
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan tunggu persetujuan admin untuk mengaktifkan akun Anda.');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar dari sistem.');
    }
}
