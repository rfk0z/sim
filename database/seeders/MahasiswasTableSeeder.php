<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MahasiswasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mahasiswas')->delete();
        
        \DB::table('mahasiswas')->insert(array (
            0 => 
            array (
                'id_nim' => 'M2025001',
                'id_user' => 3,
                'nama' => 'Mahasiswa Satu',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => '2025',
                'created_at' => '2025-06-23 18:08:19',
                'updated_at' => '2025-06-23 18:08:19',
            ),
        ));
        
        
    }
}