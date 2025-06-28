<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            TahunAjarTableSeeder::class,
            ProgramStudiTableSeeder::class,
            DosensTableSeeder::class,
            MahasiswasTableSeeder::class,
            BimbinganTableSeeder::class,
            DokumenTableSeeder::class,
        ]);
        $this->call(UsersTableSeeder::class);
        $this->call(TahunAjarTableSeeder::class);
        $this->call(ProgramStudiTableSeeder::class);
        $this->call(DokumenTableSeeder::class);
        $this->call(BimbinganTableSeeder::class);
        $this->call(DosensTableSeeder::class);
        $this->call(MahasiswasTableSeeder::class);
        $this->call(KomentarBimbinganTableSeeder::class);
    }
}
