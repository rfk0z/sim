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
        
        \DB::table('dosens')->insert(array (
            0 => 
            array (
                'id_nidn' => 'D123456',
                'id_user' => 2,
                'nama' => 'Dosen Satu',
                'jabatan' => 'Lektor',
                'created_at' => '2025-06-23 18:08:19',
                'updated_at' => '2025-06-23 18:08:19',
            ),
        ));
        
        
    }
}