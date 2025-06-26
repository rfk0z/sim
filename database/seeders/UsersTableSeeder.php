<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id_user' => 1,
                'username' => 'admin3',
                'email' => 'admin@example.com',
                'password' => '$2y$12$3mXR/wwE8YnTpsz8F74ne.m1DDpa.di7BqSjPjkJevXBqh.dDyRlm',
                'role' => 1,
                'status_verifikasi' => 'Terverifikasi',
                'foto' => 'foto-profil/KUpULGzl0KJirffrwhtnjhNRZksZLqd2pDujGwcc.jpg',
                'created_at' => '2025-06-23 18:08:19',
                'updated_at' => '2025-06-24 14:57:06',
            ),
            1 => 
            array (
                'id_user' => 2,
                'username' => 'dosen2',
                'email' => 'dosen1@example.com',
                'password' => '$2y$12$3mXR/wwE8YnTpsz8F74ne.m1DDpa.di7BqSjPjkJevXBqh.dDyRlm',
                'role' => 2,
                'status_verifikasi' => 'Terverifikasi',
                'foto' => 'foto-profil/KUpULGzl0KJirffrwhtnjhNRZksZLqd2pDujGwcc.jpg',
                'created_at' => '2025-06-23 18:08:19',
                'updated_at' => '2025-06-24 14:42:00',
            ),
            2 => 
            array (
                'id_user' => 3,
                'username' => 'mahasiswa1',
                'email' => 'mahasiswa1@example.com',
                'password' => '$2y$12$3mXR/wwE8YnTpsz8F74ne.m1DDpa.di7BqSjPjkJevXBqh.dDyRlm',
                'role' => 3,
                'status_verifikasi' => 'Terverifikasi',
                'foto' => 'foto-profil/KUpULGzl0KJirffrwhtnjhNRZksZLqd2pDujGwcc.jpg',
                'created_at' => '2025-06-23 18:08:19',
                'updated_at' => '2025-06-23 18:08:19',
            ),
        ));
        
        
    }
}