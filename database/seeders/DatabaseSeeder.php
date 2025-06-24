<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('anjay123'), // default password
            'role' => 1, // Admin
            'status_verifikasi' => 'Terverifikasi',
            'foto' => null,
        ]);

        // Dosen
        $dosenUser = User::create([
            'username' => 'dosen1',
            'email' => 'dosen1@example.com',
            'password' => Hash::make('anjay123'), // default password
            'role' => 2, // Dosen
            'status_verifikasi' => 'Terverifikasi',
            'foto' => null,
        ]);

        // Buat data dosen terkait
        Dosen::create([
            'id_nidn' => 'D123456',
            'id_user' => $dosenUser->id_user,
            'nama' => 'Dosen Satu',
            'jabatan' => 'Lektor'
        ]);

        // Mahasiswa
        $mahasiswaUser = User::create([
            'username' => 'mahasiswa1',
            'email' => 'mahasiswa1@example.com',
            'password' => Hash::make('anjay123'), // default password
            'role' => 3, // Mahasiswa
            'status_verifikasi' => 'Terverifikasi',
            'foto' => null,
        ]);

        // Buat data mahasiswa terkait
        Mahasiswa::create([
            'id_nim' => 'M2025001',
            'id_user' => $mahasiswaUser->id_user,
            'nama' => 'Mahasiswa Satu',
            'program_studi' => 'Teknik Informatika',
            'angkatan' => '2025'
        ]);
    }
}
