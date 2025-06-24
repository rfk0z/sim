<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function showlist(Request $request)
    {
        $query = User::with(['mahasiswa', 'dosen']);

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%')
                    ->orWhereHas('mahasiswa', function ($p) use ($request) {
                        $p->where('nama', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('dosen', function ($p) use ($request) {
                        $p->where('nama', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        $users = $query->paginate(10)->appends($request->query());

        $transformed = collect($users->items())->map(function ($item) {
            return [
                'id_user'           => $item->id_user,
                'email'             => $item->email,
                'role'              => $item->role,
                'nama'              => $item->mahasiswa ? $item->mahasiswa->nama : ($item->dosen ? $item->dosen->nama : $item->username),
                'nim'               => $item->mahasiswa ? $item->mahasiswa->id_nim : null,
                'nidn'              => $item->dosen ? $item->dosen->id_nidn : null,
                'username'          => $item->username,
                'status_verifikasi' => $item->status_verifikasi,
                'created_at'        => $item->created_at,
            ];
        });

        return view('admin.users.index', [
            'user'      => $users,
            'userJs'    => $transformed,
            'search'    => $request->search,
            'role'      => $request->role,
            'status'    => $request->status,
        ]);
    }

    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:50|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:1,2,3',
                'status_verifikasi' => 'required|in:Terverifikasi,Belum Terverifikasi'
            ]);

            $validated['password'] = Hash::make($validated['password']);

            User::create($validated);

            return redirect()->back()->with('success', 'User baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    public function edit(Request $request, string $id)
    {
        try {
            Log::info('Edit user request', [
                'id' => $id,
                'data' => $request->all()
            ]);

            $user = User::where('id_user', $id)->firstOrFail();

            Log::info('User found', ['user' => $user->toArray()]);

            $validated = $request->validate([
                'username' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('users', 'username')->ignore($user->id_user, 'id_user')
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($user->id_user, 'id_user')
                ],
                'role' => 'required|in:1,2,3',
                'status_verifikasi' => 'required|in:Terverifikasi,Belum Terverifikasi'
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'required|string|min:8',
                ]);
                $validated['password'] = Hash::make($request->password);
                Log::info('Password will be updated');
            }

            $updated = $user->update($validated);

            Log::info('Update result', [
                'success' => $updated,
                'user_after_update' => $user->fresh()->toArray()
            ]);

            if (!$updated) {
                throw new \Exception('Update gagal dilakukan');
            }

            return redirect()->route('user.list.index')
                ->with('success', 'Data user berhasil diperbarui.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal, periksa input Anda.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('User not found', ['id' => $id]);
            return redirect()->back()
                ->with('error', 'User tidak ditemukan.');

        } catch (\Exception $e) {
            Log::error('Update user error', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function showid(string $id)
    {
        try {
            $user = User::with(['mahasiswa', 'dosen'])->where('id_user', $id)->firstOrFail();

            $userData = [
                'id_user'           => $user->id_user,
                'email'             => $user->email,
                'role'              => $user->role,
                'username'          => $user->username,
                'nama'              => $user->mahasiswa ? $user->mahasiswa->nama : ($user->dosen ? $user->dosen->nama : $user->username),
                'nim'               => $user->mahasiswa ? $user->mahasiswa->id_nim : null,
                'nidn'              => $user->dosen ? $user->dosen->id_nidn : null,
                'status_verifikasi' => $user->status_verifikasi,
                'created_at'        => $user->created_at,
                'updated_at'        => $user->updated_at,
            ];

            return view('admin.users.show', [
                'user' => $user,
                'userData' => $userData
            ]);
        } catch (\Exception $e) {
            return redirect()->route('user.list.index')
                ->with('error', 'User tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = User::where('id_user', $id)->firstOrFail();
            $user->delete();

            return redirect()->back()->with('success', 'Data user berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
