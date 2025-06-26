<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BimbinganTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bimbingan')->delete();
        
        \DB::table('bimbingan')->insert(array (
            0 => 
            array (
                'id_bimbingan' => 2,
                'nim' => 'M2025001',
                'nidn' => 'D123456',
                'tanggal' => '2025-06-25',
                'topik' => '<p>test</p>',
                'catatan' => 'asddk',
                'status_validasi' => 'valid',
                'dokumen_url' => NULL,
            ),
            1 => 
            array (
                'id_bimbingan' => 3,
                'nim' => 'M2025001',
                'nidn' => 'D123456',
                'tanggal' => '2025-06-26',
                'topik' => '<p>testtt22</p>',
                'catatan' => 'testtt22',
                'status_validasi' => 'invalid',
                'dokumen_url' => NULL,
            ),
        ));
        
        
    }
}