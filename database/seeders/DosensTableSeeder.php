<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DosensTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('dosens')->delete();

        \DB::table('dosens')->insert([
            [
                'id_nidn' => 'D123456',
                'id_user' => 2,
                'nama' => 'Dosen Satu',
                'jabatan' => 'Lektor',
                'fakultas' => 'Teknik & Informatika',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
