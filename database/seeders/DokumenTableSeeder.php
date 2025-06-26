<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DokumenTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dokumen')->delete();
        
        \DB::table('dokumen')->insert(array (
            0 => 
            array (
                'id_dokumen' => 1,
                'id_bimbingan' => 2,
                'nama_file' => '502-Article Text-2393-2-10-20240303.pdf',
                'file_path' => 'dokumen_bimbingan/GKcBqVJ0nhK8pnPRqOqLRh3MjbpIogAneTubFjSb.pdf',
                'uploaded_at' => '2025-06-24 16:36:40',
            ),
            1 => 
            array (
                'id_dokumen' => 2,
                'id_bimbingan' => 3,
                'nama_file' => '502-Article Text-2393-2-10-20240303.pdf',
                'file_path' => 'dokumen_bimbingan/mV6ViWgWdGUQtvPNBMYeoEaBO4bXsg3HqMv26a4d.pdf',
                'uploaded_at' => '2025-06-24 18:18:24',
            ),
        ));
        
        
    }
}