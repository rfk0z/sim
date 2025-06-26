<?php

namespace App\Http\Controllers\dosen;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class DosenProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('dosen.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id_user, 'id_user'),
            ],
            'nama' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        // Update nama di relasi mahasiswa atau dosen
        if ($user->mahasiswa) {
            $user->mahasiswa->nama = $request->nama;
            $user->mahasiswa->save();
        } elseif ($user->dosen) {
            $user->dosen->nama = $request->nama;
            $user->dosen->save();
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update foto jika ada
        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }

            $path = $request->file('foto')->store('foto-profil', 'public');
            $user->foto = $path;
        }

        $user->save();

        return response()->json([
            'message' => 'Profil berhasil diperbarui.'
        ]);
    }
}
