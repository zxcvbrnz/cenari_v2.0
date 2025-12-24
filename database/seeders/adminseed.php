<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class adminseed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Tebar Kode Teknologi',
            'username' => 'cenarikursus',
            'password' => bcrypt('adm1ncenari'),
            'id_peserta' => null,
            'id_instruktur' => null,
            'role' => 'admin',
        ]);
    }
}
