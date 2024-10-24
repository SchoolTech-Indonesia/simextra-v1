<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusApplicantSeeder extends Seeder
{
    public function run()
    {
        DB::table('status_applicants')->insert([
            ['name' => 'Diterima', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ditolak', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Proses Verifikasi', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
