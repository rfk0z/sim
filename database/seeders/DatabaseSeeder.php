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
    }
}
