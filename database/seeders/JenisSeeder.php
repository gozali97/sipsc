<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'jenis_anggota' => 'Siswa',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'jenis_anggota' => 'Guru',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'jenis_anggota' => 'Karyawan',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
