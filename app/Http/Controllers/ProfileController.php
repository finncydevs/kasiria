<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        // Minimal profile placeholder to satisfy routing and allow later view rendering
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'email' => 'required|email',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil diperbarui.');
    }
}
